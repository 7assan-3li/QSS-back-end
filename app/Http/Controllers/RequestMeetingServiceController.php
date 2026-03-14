<?php

namespace App\Http\Controllers;

use App\Services\RequestMeetingServiceService;
use Illuminate\Http\Request;

class RequestMeetingServiceController extends Controller
{
    private $requestMeetingServiceService;

    public function __construct(RequestMeetingServiceService $requestMeetingServiceService)
    {
        $this->requestMeetingServiceService = $requestMeetingServiceService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'provider_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
            $result = $this->requestMeetingServiceService->store($data);

            return response()->json([
                'message' => 'تم إنشاء طلب خدمة الاجتماع بنجاح',
                'request_id' => $result['request_id']
            ], 201);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            if ($statusCode < 100 || $statusCode > 599) {
                $statusCode = 500;
            }
            return response()->json([
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }
}
