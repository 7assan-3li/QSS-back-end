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
        $meetingService = Service::where('provider_id', $user_id)
            ->where('type', ServiceType::MEETING)
            ->first();
        
        if ($meetingService) {
            $meetingService->load('schedules.days');
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

    public function getCustomService($user_id)
    {
        $customService = Service::where('provider_id', $user_id)
            ->where('type', ServiceType::CUSTOM)
            ->first();
        
        if ($customService) {
            $customService->load('schedules.days');
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
