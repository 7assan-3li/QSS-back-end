<?php

namespace App\Http\Controllers;

use App\constant\ServiceType;
use App\Http\Requests\UpdateMeetingAndCustomServiceRequest;
use App\Models\Service;
use App\Services\MeetingServiceService;
use App\Services\CustomServiceService;
use Illuminate\Support\Facades\Auth;

class MeetingAndCustomServiceController extends Controller
{
    public function __construct(MeetingServiceService $meetingServiceService, CustomServiceService $customServiceService)
    {
        $this->meetingServiceService = $meetingServiceService;
        $this->customServiceService = $customServiceService;
    }

    public function getMeetingService()
    {
        $meetingService = Service::where('provider_id', Auth::user()->id)->where('type', 'meeting')->first();
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
        return response()->json([
            'data' => $meetingService,
            'message' => 'Meeting service retrieved successfully'
        ], 200);
    }
    public function updateMeetingService(UpdateMeetingAndCustomServiceRequest $request)
    {
        $meetingService = $this->meetingServiceService->update($request->validated());
        return response()->json([
            'data' => $meetingService,
            'message' => 'Meeting service updated successfully'
        ], 200);
    }

    public function getCustomService()
    {
        $customService = Service::where('provider_id', Auth::user()->id)->where('type', 'custom')->first();
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
        return response()->json([
            'data' => $customService,
            'message' => 'Custom service retrieved successfully'
        ], 200);
    }
    public function updateCustomService(UpdateMeetingAndCustomServiceRequest $request)
    {
        $customService = $this->customServiceService->update($request->validated());
        return response()->json([
            'data' => $customService,
            'message' => 'Custom service updated successfully'
        ], 200);
    }
}
