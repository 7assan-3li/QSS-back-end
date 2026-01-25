<?php

namespace App\Services;

use App\constant\RequestStatus;
use App\Models\RequestCommissionBond;
use App\Models\Request as RequestModel;

class RequestCommissionBondService
{

    public function create(array $data)
    {
        $requestModel = RequestModel::findOrFail($data['request_id']);

        // تحقق من حالة الطلب
        if ($requestModel->status !== RequestStatus::COMPLETED) {
            return response()->json([
                'message' => 'لا يمكن رفع سند قبل اكتمال الطلب',
                'requestStatus' => $requestModel->status,
            ], 422);
        }

        // حفظ الصورة
        $path = $data['image']->store('CommissionBonds', 'public');

        // إنشاء السند
        $commissionBond = RequestCommissionBond::create([
            'request_id'  => $data['request_id'],
            'image_path'  => $path,
            'bond_number' => $data['bond_number'] ?? null,
            'description' => $data['description'] ?? null,
        ]);


        return $commissionBond;
    }
}
