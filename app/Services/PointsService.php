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
            $bonusAmount = $this->calculateBonusPoints($request);
            $user->bonus_points += $bonusAmount;
            
            $request->bonus_points_awarded = true;
            
            $request->save();
            $user->save();

            \App\Models\PointTransaction::create([
                'seeker_id' => $userId,
                'provider_id' => null, // Bonus from system
                'request_id' => $requestId,
                'amount' => $bonusAmount,
                'type' => 'bonus',
            ]);
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
            
            // تحديث حالة الطلب بناءً على النسبة المطلوبة
            if ($request->money_paid >= $request->total_price) {
                $request->status = RequestStatus::ACCEPTED_FULL_PAID; 
            } elseif ($request->money_paid >= $request->getRequiredPartialAmount()) {
                $request->status = RequestStatus::ACCEPTED_PARTIAL_PAID;
            }

            $request->save();
            $provider->save();
            $seeker->save();

            \App\Models\PointTransaction::create([
                'seeker_id' => $seeker->id,
                'provider_id' => $provider->id,
                'request_id' => $requestId,
                'amount' => $transferred_points,
                'type' => 'payment',
            ]);

            return $request;
        });
    }

    public function payCommissionFromPoints($requestId)
    {
        return DB::transaction(function () use ($requestId) {
            $request = RequestModel::lockForUpdate()->findOrFail($requestId);
            
            // حساب المبلغ المطلوب وتخزينه كثابت للطلب إذا لم يكن مخزناً
            if ($request->commission_amount <= 0) {
                $request->commission_amount = $request->getCommissionAmount();
            }

            $amountNeeded = $request->commission_amount - $request->commission_amount_paid;

            if ($amountNeeded <= 0) {
                $request->commission_paid = true;
                $request->save();
                return $request;
            }

            $providerModel = $request->serviceProvider();
            if (!$providerModel) {
                return $request;
            }

            $provider = User::lockForUpdate()->findOrFail($providerModel->id);
            $totalDeducted = 0;

            // 1. الخصم من نقاط المكافأة أولاً
            if ($provider->bonus_points > 0) {
                $bonusToDeduct = min($provider->bonus_points, $amountNeeded);
                $provider->bonus_points -= $bonusToDeduct;
                $amountNeeded -= $bonusToDeduct;
                $totalDeducted += $bonusToDeduct;

                \App\Models\PointTransaction::create([
                    'seeker_id' => null,
                    'provider_id' => $provider->id,
                    'request_id' => $requestId,
                    'amount' => $bonusToDeduct,
                    'type' => 'commission_payment_bonus',
                ]);
            }

            // 2. الخصم من نقاط الأرباح إذا كانت المكافآت لا تكفي
            if ($amountNeeded > 0 && $provider->paid_points > 0) {
                $paidToDeduct = min($provider->paid_points, $amountNeeded);
                $provider->paid_points -= $paidToDeduct;
                $amountNeeded -= $paidToDeduct;
                $totalDeducted += $paidToDeduct;

                \App\Models\PointTransaction::create([
                    'seeker_id' => null,
                    'provider_id' => $provider->id,
                    'request_id' => $requestId,
                    'amount' => $paidToDeduct,
                    'type' => 'commission_payment_paid',
                ]);
            }

            // تحديث الطلب
            $request->commission_amount_paid += $totalDeducted;
            if ($request->commission_amount_paid >= $request->commission_amount) {
                $request->commission_paid = true;
            }

            $request->save();
            $provider->save();

            return $request;
        });
    }

    public function convertPaidToBonus($userId, $amount)
    {
        if ($amount <= 0) {
            throw new \Exception("المبلغ المختار للتحويل يجب أن يكون أكبر من الصفر");
        }

        return DB::transaction(function () use ($userId, $amount) {
            $user = User::lockForUpdate()->findOrFail($userId);

            if ($user->paid_points < $amount) {
                throw new \Exception("رصيد الأرباح (Paid Points) غير كافٍ لإتمام التحويل");
            }

            // حساب مبلغ المكافأة مع الحافز الديناميكي
            $conversionBonusRate = \App\Models\Setting::where('key', 'provider_conversion_bonus')->value('value') ?? 1;
            $bonusAmount = $amount * (1 + ($conversionBonusRate / 100));

            $user->paid_points -= $amount;
            $user->bonus_points += $bonusAmount;
            $user->save();

            \App\Models\PointTransaction::create([
                'seeker_id'   => null,
                'provider_id' => $user->id,
                'request_id'  => null,
                'amount'      => $amount,
                'type'        => 'points_conversion',
                'description' => "تحويل $amount من الأرباح إلى $bonusAmount من المكافآت (حافز $conversionBonusRate%)"
            ]);

            return [
                'paid_points_deducted' => $amount,
                'bonus_points_added'   => $bonusAmount,
                'new_paid_points'      => $user->paid_points,
                'new_bonus_points'     => $user->bonus_points,
            ];
        });
    }

    private function calculateBonusPoints($request)
    {
        $seekerBonusRate = \App\Models\Setting::where('key', 'seeker_bonus')->value('value') ?? 10;
        return $request->total_price * ($seekerBonusRate / 100);
    }

    private function checkRequestStatusToPay($request)
    {
        return $request->status == RequestStatus::ACCEPTED_INITIAL || $request->status == RequestStatus::ACCEPTED_PARTIAL_PAID;
    }

    public function getUserPoints($userId)
    {
        $user = User::findOrFail($userId);
        return [
            'bonus_points' => $user->bonus_points,
            'paid_points'  => $user->paid_points,
        ];
    }
}
