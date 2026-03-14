<?php

namespace App\Services;

use App\constant\ServiceType;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;


class CustomServiceService
{
    public function update(array $data){
        $customService = Service::where('provider_id', Auth::user()->id)
        ->where('type', ServiceType::CUSTOM)
        ->first();
        if (!$customService) {
            $customService = Service::create([
                'provider_id' => Auth::user()->id,
                'type' => ServiceType::CUSTOM,
                'distance_based_price' => true,
                'price_per_km' => 0,
                'is_active' => true,
                'price' => 0,
                'description' => '',
                'name' => '_custom',
            ]);
        }
        $customService->update($data);
        return $customService;
    }
   
}
