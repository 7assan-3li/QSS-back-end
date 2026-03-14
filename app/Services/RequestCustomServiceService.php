<?php

namespace App\Services;

use App\Models\Request as RequestModel;
use App\Models\Service;
use App\constant\ServiceType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class RequestCustomServiceService
{
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

        $request_id = null;

        DB::transaction(function () use ($data, $customService, &$request_id) {
            $requestModel = RequestModel::create([
                'user_id' => Auth::user()->id,
                'message' => $data['message'],
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'total_price' => $customService->price, // Default price, might be 0 until negotiated
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
}
