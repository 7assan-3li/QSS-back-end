<?php

namespace App\Services;

use App\constant\ServiceType;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;


class CustomServiceService
{
    public function update(array $data){
        $customService = Service::firstOrCreate(
            ['provider_id' => Auth::user()->id, 'type' => ServiceType::CUSTOM],
            [
                'distance_based_price' => true,
                'price_per_km' => 0,
                'is_active' => true,
                'price' => 0,
                'description' => '',
                'name' => '_custom',
            ]
        );
        $customService->update([
            'description' => $data['description'],
            'is_active' => $data['is_active'],
        ]);
        return $customService;
    }
   
}
