<?php

namespace App\Services;

use App\constant\RequestStatus;
use App\constant\ServiceType;
use App\Models\Request as RequestModel;

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

}
