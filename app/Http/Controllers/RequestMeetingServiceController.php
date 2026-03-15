<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProviderMeetingRequest;
use App\Http\Requests\IndexSeekerMeetingRequest;
use App\Http\Requests\StoreRequestMeetingServiceRequest;
use App\Services\RequestMeetingServiceService;
use Illuminate\Http\Request;

class RequestMeetingServiceController extends Controller
{
    private $requestMeetingServiceService;

    public function __construct(RequestMeetingServiceService $requestMeetingServiceService)
    {
        $this->requestMeetingServiceService = $requestMeetingServiceService;
    }

    public function indexProvider(IndexProviderMeetingRequest $request)
    {
        $data = $request->validated();

        try {
            $result = $this->requestMeetingServiceService->indexProvider($data);

            return response()->json([
                'message' => 'تم الحصول على طلبات خدمات الاجتماع بنجاح',
                'requests' => $result['requests']
            ], 200);
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

    public function indexSeeker(IndexSeekerMeetingRequest $request)
    {
        $data = $request->validated();

        try {
            $result = $this->requestMeetingServiceService->indexSeeker($data);

            return response()->json([
                'message' => 'تم الحصول على طلبات خدمات الاجتماع بنجاح',
                'requests' => $result['requests']
            ], 200);
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

    public function store(StoreRequestMeetingServiceRequest $request)
    {
        $data = $request->validated();

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
