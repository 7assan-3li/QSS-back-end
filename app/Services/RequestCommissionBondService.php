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

        // التحقق من أن المستخدم هو مزود الخدمة لهذا الطلب
        $provider = $requestModel->serviceProvider();
        if (!$provider || $provider->id !== auth()->id()) {
             // استخدام response()->json() مباشرة قد لا يكون الأفضل في Service، 
             // لكن بما أن الكنترولر لا يعالج الاستثناءات حالياً سنقوم بذلك لضمان التوافق
            abort(403, 'غير مصرح لك برفع سند عمولة لهذا الطلب');
        }

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
            'amount'      => $data['amount'],
            'bond_number' => $data['bond_number'] ?? null,
            'description' => $data['description'] ?? null,
        ]);


        return $commissionBond;
    }
}
