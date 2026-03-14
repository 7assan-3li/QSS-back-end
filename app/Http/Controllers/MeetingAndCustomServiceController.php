<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMeetingAndCustomServiceRequest;
use App\Services\MeetingServiceService;
use App\Services\CustomServiceService;

class MeetingAndCustomServiceController extends Controller
{
    public function __construct(MeetingServiceService $meetingServiceService, CustomServiceService $customServiceService){
        $this->meetingServiceService = $meetingServiceService;
        $this->customServiceService = $customServiceService;
    }

    public function updateMeetingService(UpdateMeetingAndCustomServiceRequest $request){
        $meetingService = $this->meetingServiceService->update($request->validated());
        return response()->json([
            'data' => $meetingService,
            'message' => 'Meeting service updated successfully'
        ], 200);
    }

    public function updateCustomService(UpdateMeetingAndCustomServiceRequest $request){
        $customService = $this->customServiceService->update($request->validated());
        return response()->json([
            'data' => $customService,
            'message' => 'Custom service updated successfully'
        ], 200);
    }
}
