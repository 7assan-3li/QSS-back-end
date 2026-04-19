<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProviderMeetingRequest;
use App\Http\Requests\IndexSeekerMeetingRequest;
use App\Http\Requests\StoreRequestMeetingServiceRequest;
use App\Services\RequestMeetingServiceService;
use App\Services\NotificationService;

class RequestMeetingServiceController extends Controller
{
    public function __construct(
        private RequestMeetingServiceService $requestMeetingServiceService,
        private NotificationService $notificationService
    ) {}

    public function indexProvider()
    {
        try {
            $result = $this->requestMeetingServiceService->indexProvider(['provider_id' => auth()->id()]);

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

    public function indexSeeker()
    {
        try {
            $result = $this->requestMeetingServiceService->indexSeeker(['seeker_id' => auth()->id()]);

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

            // إشعار لمزود الخدمة بطلب اجتماع جديد
            $meetingRequest = \App\Models\Request::find($result['request_id']);
            $providerId = $meetingRequest->main_service->provider_id;
            $this->notificationService->sendToUser(
                $providerId,
                'طلب اجتماع جديد 🗓️',
                'لديك طلب اجتماع جديد، يرجى مراجعة التفاصيل والموافقة.',
                \App\Constants\NotificationType::NEW_REQUEST,
                ['request_id' => $result['request_id']]
            );

            // إشعار تأكيد لطالب الخدمة
            $this->notificationService->sendToUser(
                auth()->id(),
                'تم إرسال طلب الاجتماع 📡',
                'تم إرسال طلبك بنجاح وهو بانتظار موافقة المزود.',
                \App\Constants\NotificationType::GENERAL
            );

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
