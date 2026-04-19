<?php

namespace App\Http\Controllers;

use App\Services\RequestCustomServiceService;
use Illuminate\Http\Request;

class RequestCustomServiceController extends Controller
{

    public function __construct(
        private  $requestCustomServiceService,
        private \App\Services\NotificationService $notificationService
    ) {}

    public function indexProvider()
    {
        $result = $this->requestCustomServiceService->indexProvider(['provider_id' => auth()->id()]);
        return response()->json($result['requests']);
    }

    public function indexSeeker()
    {
        $result = $this->requestCustomServiceService->indexSeeker(['seeker_id' => auth()->id()]);
        return response()->json($result['requests']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'provider_id' => 'required|exists:users,id',
            'message' => 'required|string', // For custom services, message is usually required to describe requirements
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
            $result = $this->requestCustomServiceService->store($data);

            // إشعار لمزود الخدمة بطلب خدمة مخصصة جديد
            $this->notificationService->sendToUser(
                $data['provider_id'],
                'طلب خدمة مخصصة 🛠️',
                'لديك طلب جديد لخدمة مخصصة، يرجى مراجعة الوصف وتحديد السعر.',
                \App\Constants\NotificationType::NEW_REQUEST,
                ['request_id' => $result['request_id']]
            );

            // إشعار تأكيد لطالب الخدمة
            $this->notificationService->sendToUser(
                auth()->id(),
                'تم إرسال طلب الخدمة 📡',
                'تم إرسال طلبك بنجاح وسيتم إخطارك فور تحديد السعر من قبل المزود.',
                \App\Constants\NotificationType::GENERAL
            );

            return response()->json([
                'message' => 'تم إنشاء طلب الخدمة المخصصة بنجاح',
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

    public function setPrice(Request $request, $id)
    {
        $data = $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        try {
            $this->requestCustomServiceService->setPrice((int)$id, $data['price']);

            // إشعار لطالب الخدمة بتحديد السعر
            $customRequest = \App\Models\Request::find($id);
            $this->notificationService->sendToUser(
                $customRequest->user_id,
                'تم تحديد سعر الخدمة 💰',
                "تم تحديد سعر طلبك المخصص بمبلغ {$data['price']} ريال. يمكنك الآن المتابعة للدقع.",
                \App\Constants\NotificationType::REQUEST_ACCEPTED,
                ['request_id' => $id]
            );

            return response()->json([
                'message' => 'تم تحديد السعر وتحديث حالة الطلب بنجاح',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'الطلب غير موجود'
            ], 404);
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

    public function reject($id)
    {
        try {
            $this->requestCustomServiceService->reject((int)$id);

            // إشعار لطالب الخدمة بالرفض
            $customRequest = \App\Models\Request::find($id);
            $this->notificationService->sendToUser(
                $customRequest->user_id,
                'رفض طلب الخدمة المخصصة ❌',
                'نعتذر، لقد تم رفض طلبك للخدمة المخصصة من قبل المزود.',
                \App\Constants\NotificationType::REQUEST_REJECTED,
                ['request_id' => $id]
            );

            return response()->json([
                'message' => 'تم رفض الطلب بنجاح',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'الطلب غير موجود'
            ], 404);
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
