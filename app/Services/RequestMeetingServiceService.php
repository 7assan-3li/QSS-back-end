<?php

namespace App\Services;

use App\Models\Request as RequestModel;
use App\Models\Service;
use App\constant\ServiceType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class RequestMeetingServiceService
{
    public function indexProvider($data)
    {
        $requests = RequestModel::with('user', 'main_service')
            ->whereHas('main_service', function ($query) use ($data) {
                $query->where('provider_id', $data['provider_id'])
                      ->where('type', ServiceType::MEETING);
            })->get();

        return ['requests' => $requests];
    }

    public function indexSeeker($data)
    {
        $requests = RequestModel::with('main_service')
            ->where('user_id', $data['seeker_id'])
            ->whereHas('main_service', function ($query) {
                $query->where('type', ServiceType::MEETING);
            })->get();

        return ['requests' => $requests];
    }

    

    public function store($data)
    {
        // Find the active Meeting Service for the given provider
        $meetingService = Service::where('provider_id', $data['provider_id'])
            ->where('type', ServiceType::MEETING)
            ->where('is_active', true)
            ->first();

        if (!$meetingService) {
            throw new Exception('لا توجد خدمة اجتماع مفعلة لهذا المزود.', 404);
        }

        $request_id = null;

        // Eager load the profile to get the provider's latitude and longitude
        $provider = User::with('profile')->find($data['provider_id']);

        // وضح موقع طالب الخدمة اذا كان موقع الطلب فارغ وكان الخدمة تعتمد على المسافة
        if ($meetingService->distance_based_price) {
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

        $totalPrice = $meetingService->price;

        // Calculate distance price if applicable
        if ($meetingService->distance_based_price && isset($data['latitude'], $data['longitude'])) {
            $providerLat = $provider->profile->latitude ?? null;
            $providerLng = $provider->profile->longitude ?? null;

            if ($providerLat && $providerLng) {
                $distanceKm = \App\Helpers\LocationHelper::calculateDistance(
                    $providerLat,
                    $providerLng,
                    $data['latitude'],
                    $data['longitude']
                );

                $totalPrice += ($distanceKm * $meetingService->price_per_km);
            }
        }

        DB::transaction(function () use ($data, $meetingService, &$request_id, $totalPrice) {
            $requestModel = RequestModel::create([
                'user_id' => Auth::user()->id,
                'message' => $data['message'] ?? null,
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'total_price' => $totalPrice,
            ]);

            $request_id = $requestModel->id;

            // Attach the meeting service to the request
            $requestModel->services()->attach($meetingService->id, [
                'quantity' => 1,
                'is_main' => true
            ]);
        });

        return ['request_id' => $request_id];
    }
}
