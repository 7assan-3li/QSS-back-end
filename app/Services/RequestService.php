<?php

namespace App\Services;

use App\constant\RequestStatus;
use App\Models\Request as RequestModel;

class RequestService{

    public function getAllRequests($httpRequest){
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

        $requests = $query->latest()->paginate(9);

        // التقارير
        $stats = [
            'total'      => \App\Models\Request::count(),
            'pending'    => \App\Models\Request::where('status', 'pending')->count(),
            'completed'  => \App\Models\Request::where('status', 'completed')->count(),
            'unpaid'     => \App\Models\Request::where('commission_paid', false)->count(),
        ];

        return ['requests'=> $requests,'stats'=>$stats];

    }

    public function markPaid($data)
    {
        // تحديث حالة الطلب
        $data->update([
            'commission_paid' => true
        ]);
    }

}
