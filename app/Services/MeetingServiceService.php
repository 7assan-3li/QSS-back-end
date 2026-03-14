<?php

namespace App\Services;

use App\constant\ServiceType;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;


class MeetingServiceService
{
    public function update(array $data){
        $meetingService = Service::where('provider_id', Auth::user()->id)
        ->where('type', ServiceType::MEETING)
        ->first();
        if (!$meetingService) {
            $meetingService = Service::create([
                'provider_id' => Auth::user()->id,
                'type' => ServiceType::MEETING,
                'distance_based_price' => true,
                'price_per_km' => 0,
                'is_active' => true,
                'price' => 0,
                'description' => '',
                'name' => '_meeting',
            ]);
        }
        $meetingService->update($data);
        return $meetingService;
    }
   
}
