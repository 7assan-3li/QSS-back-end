<?php

namespace App\Services;

use App\constant\RequestStatus;
use App\Models\User;
use App\Models\Request as RequestModel;
use DB;

class PointsService
{
    public function addBonusPoints($userId, $requestId)
    {
        DB::transaction(function () use ($userId, $requestId) {
            $request = RequestModel::lockForUpdate()->findOrFail($requestId);
            
            if ($request->status != RequestStatus::COMPLETED || $request->bonus_points_awarded) {
                return;
            }

            $user = User::lockForUpdate()->findOrFail($userId);
            $user->bonus_points += $this->calculateBonusPoints($request);
            
            $request->bonus_points_awarded = true;
            
            $request->save();
            $user->save();
        });
    }

    public function payRequest($requestId, $transferred_points)
    {
        if ($transferred_points <= 0) {
            throw new \Exception("قيمة النقاط المحولة يجب أن تكون أكبر من الصفر");
        }

        return DB::transaction(function () use ($requestId, $transferred_points) {
            $request = RequestModel::lockForUpdate()->findOrFail($requestId);
            if (!$this->checkRequestStatusToPay($request)) {
                throw new \Exception("حالة الطلب لا تسمح بعملية الدفع");
            }

            $current_money_paid = $request->money_paid ?? 0;
            if (($current_money_paid + $transferred_points) > $request->total_price) {
                throw new \Exception("المبلغ المدفوع يتجاوز التكلفة الإجمالية للطلب");
            }

            $seeker = User::lockForUpdate()->findOrFail($request->user_id);
            if ($seeker->bonus_points < $transferred_points) {
                throw new \Exception("رصيد النقاط غير كافٍ لإتمام الحوالة");
            }

            $providerModel = $request->serviceProvider();
            if (!$providerModel) {
                throw new \Exception("لم يتم العثور على مقدم الخدمة لهذا الطلب");
            }

            $provider = User::lockForUpdate()->findOrFail($providerModel->id);

            $provider->paid_points += $transferred_points;
            $seeker->bonus_points -= $transferred_points;
            $request->money_paid = $current_money_paid + $transferred_points;
            
            // update request status to accepted full paid or accepted partial paid
            if ($request->money_paid >= $request->total_price) {
                $request->status = RequestStatus::ACCEPTED_FULL_PAID; 
            } else {
                $request->status = RequestStatus::ACCEPTED_PARTIAL_PAID;
            }

            $request->save();
            $provider->save();
            $seeker->save();

            return true;
        });
    }

    private function calculateBonusPoints($request)
    {
        return $request->total_price * 0.1;
    }

    private function checkRequestStatusToPay($request)
    {
        return $request->status == RequestStatus::ACCEPTED_INITIAL || $request->status == RequestStatus::ACCEPTED_PARTIAL_PAID;
    }
}
