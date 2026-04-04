<?php

namespace App\Services;

use App\Models\Request as RequestModel;
use App\Models\Service;
use App\constant\ServiceType;
use App\constant\RequestStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class RequestCustomServiceService
{
    public function indexProvider($data)
    {
        $requests = RequestModel::with('user', 'main_service')
            ->whereHas('main_service', function ($query) use ($data) {
                $query->where('provider_id', $data['provider_id'])
                      ->where('type', ServiceType::CUSTOM);
            })->get();

        return ['requests' => $requests];
    }

    public function indexSeeker($data)
    {
        $requests = RequestModel::with('main_service')
            ->where('user_id', $data['seeker_id'])
            ->whereHas('main_service', function ($query) {
                $query->where('type', ServiceType::CUSTOM);
            })->get();

        return ['requests' => $requests];
    }

    public function store($data)
    {
        // Find the active Custom Service for the given provider
        $customService = Service::where('provider_id', $data['provider_id'])
            ->where('type', ServiceType::CUSTOM)
            ->where('is_active', true)
            ->first();

        if (!$customService) {
            throw new Exception('لا توجد خدمة مخصصة مفعلة لهذا المزود.', 404);
        }

        // وضح موقع طالب الخدمة اذا كان موقع الطلب فارغ وكان الخدمة تعتمد على المسافة
        if ($customService->distance_based_price) {
            if (empty($data['latitude']) || empty($data['longitude'])) {
                $userProfile = Auth::user()->profile;
                if ($userProfile) {
                    $data['latitude'] = $userProfile->latitude;
                    $data['longitude'] = $userProfile->longitude;
                }
            }
            if (empty($data['latitude']) || empty($data['longitude'])) {
                throw new Exception('لا يمكن حساب المسافة، يرجى تفعيل الموقع أو إدخال الإحداثيات.');
            }
        }

        $request_id = null;

        DB::transaction(function () use ($data, $customService, &$request_id) {
            $requestModel = RequestModel::create([
                'user_id' => Auth::user()->id,
                'message' => $data['message'],
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'total_price' => 0, // Default price is 0 until negotiated by provider
            ]);

            $request_id = $requestModel->id;

            // Attach the custom service to the request
            $requestModel->services()->attach($customService->id, [
                'quantity' => 1,
                'is_main' => true
            ]);
        });

        return ['request_id' => $request_id];
    }

    public function reject(int $requestId)
    {
        $requestModel = RequestModel::findOrFail($requestId);

        // Ensure the request belongs to a custom service
        $customService = $requestModel->services()->wherePivot('is_main', true)->where('type', ServiceType::CUSTOM)->first();
        if (!$customService) {
            throw new Exception('الطلب لا ينتمي لخدمة مخصصة.', 400);
        }

        // Verify the logged-in user is the provider of this request
        if ($customService->provider_id !== Auth::id()) {
            throw new Exception('غير مصرح لك برفض هذا الطلب.', 403);
        }

        // Verify the status is pending
        if ($requestModel->status !== RequestStatus::PENDING) {
            throw new Exception('لا يمكن الرفض، حالة الطلب الحالية لا تسمح بذلك.', 400);
        }

        $requestModel->update([
            'status' => RequestStatus::REJECTED,
        ]);

        return $requestModel;
    }

    public function setPrice(int $requestId, float $price)
    {
        $requestModel = RequestModel::findOrFail($requestId);

        // Ensure the request belongs to a custom service
        $customService = $requestModel->services()->wherePivot('is_main', true)->where('type', ServiceType::CUSTOM)->first();
        if (!$customService) {
            throw new Exception('الطلب لا ينتمي لخدمة مخصصة.', 400);
        }

        // Verify the logged-in user is the provider of this request
        if ($customService->provider_id !== Auth::id()) {
            throw new Exception('غير مصرح لك بتحديد السعر لهذا الطلب.', 403);
        }

        // Verify the status is pending
        if ($requestModel->status !== RequestStatus::PENDING) {
            throw new Exception('لا يمكن تحديد السعر، حالة الطلب الحالية لا تسمح بذلك.', 400);
        }

        // Update the request
        $requestModel->update([
            'total_price' => $price,
            'status' => RequestStatus::ACCEPTED_INITIAL,
        ]);

        return $requestModel;
    }
}
