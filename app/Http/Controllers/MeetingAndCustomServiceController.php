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
    private MeetingServiceService $meetingServiceService;
    private CustomServiceService $customServiceService;

    public function __construct(MeetingServiceService $meetingServiceService, CustomServiceService $customServiceService)
    {
        $this->meetingServiceService = $meetingServiceService;
        $this->customServiceService = $customServiceService;
    }

    public function getMeetingService($user_id)
    {
        $meetingService = Service::firstOrCreate(
            ['provider_id' => $user_id, 'type' => ServiceType::MEETING],
            [
                'distance_based_price' => true,
                'price_per_km' => 0,
                'is_active' => true,
                'price' => 0,
                'description' => '',
                'name' => '_meeting',
            ]
        );
        
        $meetingService->load('schedules.days');
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

    public function getCustomService($user_id)
    {
        $customService = Service::firstOrCreate(
            ['provider_id' => $user_id, 'type' => ServiceType::CUSTOM],
            [
                'distance_based_price' => true,
                'price_per_km' => 0,
                'is_active' => true,
                'price' => 0,
                'description' => '',
                'name' => '_custom',
            ]
        );
        
        $customService->load('schedules.days');
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
