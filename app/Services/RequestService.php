<?php

namespace App\Services;

use App\constant\RequestStatus;
use App\constant\ServiceType;
use App\Models\Request as RequestModel;
use Illuminate\Support\Facades\DB;

class RequestService
{

    public function getAllRequests($httpRequest)
    {
        // فلترة حسب الحالة
        $query = RequestModel::with(['user', 'services']);

        // فلترة حسب الحالة
        if ($httpRequest->status) {
            $query->where('status', $httpRequest->status);
        }

        // فلترة العمولة
        if ($httpRequest->commission === 'paid') {
            $query->where('commission_paid', true);
        }

        if ($httpRequest->commission === 'unpaid') {
            $query->where('commission_paid', false);
        }
        // الطلبات المخصصة
        if ($httpRequest->type === ServiceType::CUSTOM) {
            $query->whereHas('services', function ($q) {
                $q->where('type', ServiceType::CUSTOM);
            });
        }
        // الطلبات الاجتماعات
        if ($httpRequest->type === ServiceType::MEETING) {
            $query->whereHas('services', function ($q) {
                $q->where('type', ServiceType::MEETING);
            });
        }

        $requests = $query->latest()->paginate(9);

        // التقارير
        $stats = [
            'total' => RequestModel::count(),
            'pending' => RequestModel::where('status', 'pending')->count(),
            'completed' => RequestModel::where('status', 'completed')->count(),
            'unpaid' => RequestModel::where('commission_paid', false)->count(),
            'custom' => RequestModel::whereHas('services', function ($q) {
                $q->where('type', ServiceType::CUSTOM);
            })->count(),
            'meeting' => RequestModel::whereHas('services', function ($q) {
                $q->where('type', ServiceType::MEETING);
            })->count(),
        ];

        return ['requests' => $requests, 'stats' => $stats];

    }

    public function markPaid($data)
    {
        // تحديث حالة الطلب
        $data->update([
            'commission_paid' => true
        ]);
    }

    public function addToMoneyPaid($requestId, $addedAmount)
    {
        return DB::transaction(function () use ($requestId, $addedAmount) {
            $request = RequestModel::lockForUpdate()->findOrFail($requestId);

            if ($request->status != RequestStatus::ACCEPTED_INITIAL && $request->status != RequestStatus::ACCEPTED_PARTIAL_PAID) {
                throw new \Exception("حالة الطلب لا تسمح بعملية الدفع");
            }

            if ($request->money_paid + $addedAmount > $request->total_price) {
                throw new \Exception("المبلغ المدفوع يتجاوز التكلفة الإجمالية للطلب");
            }

            if ($addedAmount <= 0) {
                throw new \Exception("المبلغ المدفوع يجب أن يكون أكبر من الصفر");
            }

            $request->money_paid += $addedAmount;

            // تحديث الحالة بناءً على النسبة المحددة في الخدمة
            if ($request->money_paid >= $request->total_price) {
                $request->status = RequestStatus::ACCEPTED_FULL_PAID;
            } elseif ($request->money_paid >= $request->getRequiredPartialAmount()) {
                $request->status = RequestStatus::ACCEPTED_PARTIAL_PAID;
            }

            $request->save();
            return $request;
        });
    }

    // تحديث حالة الطلب بعد فحص المبلغ المدفوع (للاستخدام العام)
    public function updateRequestStatus($requestId)
    {
        return DB::transaction(function () use ($requestId) {
            $request = RequestModel::lockForUpdate()->findOrFail($requestId);
            if ($request->money_paid >= $request->total_price) {
                $request->status = RequestStatus::ACCEPTED_FULL_PAID;
            } else {
                $request->status = RequestStatus::ACCEPTED_PARTIAL_PAID;
            }
            $request->save();
            return $request;
        });
    }

    // public function addAmountToMoneyPaid($requestId,$addedAmount){
    //     $request = RequestModel::lockForUpdate()->findOrFail($requestId);
    //     if($request->status != RequestStatus::ACCEPTED_INITIAL && $request->status != RequestStatus::ACCEPTED_PARTIAL_PAID){
    //         throw new \Exception("حالة الطلب لا تسمح بعملية الدفع");
    //     }
    //     if($request->money_paid + $addedAmount > $request->total_price){
    //         throw new \Exception("المبلغ المدفوع يتجاوز التكلفة الإجمالية للطلب");
    //     }
    //     if($addedAmount <= 0)
    //         throw new \Exception("المبلغ المدفوع يجب أن يكون أكبر من الصفر");
    //     $request->money_paid += $addedAmount;
    //     $request->save();

    //     // تحديث حالة الطلب
    //     $this->updateRequestStatus($requestId);
    //     return $request;
    // } 

}
