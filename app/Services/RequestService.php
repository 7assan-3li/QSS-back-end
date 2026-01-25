<?php

namespace App\Services;

use App\constant\RequestStatus;

class RequestService{

    public function markPaid($data)
    {
        // التحقق من حالة الطلب
      

        // تحديث حالة الطلب
        $data->update([
            'commission_paid' => true
        ]);
    }

}
