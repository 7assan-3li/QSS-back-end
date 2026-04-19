<?php

namespace App\Http\Controllers;

use App\constant\RequestStatus;
use App\Models\Request as RequestModel;
use App\Models\Service;
use App\Rules\SubServiceBelongsToMain;
use App\Services\PointsService;
use App\Services\RequestService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    use AuthorizesRequests;

    //constructor
    public function __construct(
        private PointsService $pointsService,
        private RequestService $requestService,
        private \App\Services\NotificationService $notificationService
    ) {
    }
    public function index()
    {
        $requests = RequestModel::with(['user', 'main_service', 'sub_services'])->get();
        return response()->json($requests);
    }
    public function indexSeeker()
    {
        $requests = $this->requestService->getAllSeekerRequests(Auth::user()->id);
        return response()->json($requests);
    }
    public function indexProvider()
    {
        $requests = $this->requestService->getAllProviderRequests(Auth::user()->id);
        return response()->json($requests);
    }
    public function store(Request $request)
    {

        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'message' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'sup_services' => 'nullable|array',
            'sup_services.*.id' => ['required', 'exists:services,id', new SubServiceBelongsToMain($request->service_id)],
            'sup_services.*.quantity' => 'integer|min:1',
        ]);

        // التحقق من تكرار الخدمات الفرعية
        if (!empty($data['sup_services'])) {
            $subServiceIds = collect($data['sup_services'])->pluck('id');

            if ($subServiceIds->count() !== $subServiceIds->unique()->count()) {
                return response()->json([
                    'message' => 'إحدى الخدمات الفرعية مكررة'
                ], 422);
            }
        }


        $mainService = Service::findOrFail($data['service_id']);
        // if (!empty($data['sup_services'])) {
        //     $validSubServiceIds = $mainService->children()->pluck('id')->toArray();
        //     foreach ($data['sup_services'] as $sub) {
        //         if (!in_array($sub['id'], $validSubServiceIds)) {
        //             return response()->json([
        //                 'message' => 'إحدى الخدمات الفرعية غير تابعة للخدمة الرئيسية'
        //             ], 422);
        //         }
        //     }
        // }



        //--------
        // if (!empty($data['sup_services'])) {
        //     foreach ($data['sup_services'] as $subService) {

        //         $service = Service::findOrFail($subService['id']);
        //         if (!$service || (int) $service->service_id !== (int) $mainService->id) {
        //             return response()->json([
        //                 'message' => 'إحدى الخدمات الفرعية لا تتبع الخدمة الرئيسية المحددة'
        //             ], 422);
        //         }
        //     }
        // }
        //------

        // if (!empty($data['sup_services'])) {

        //     // جلب كل الخدمات الفرعية التابعة للخدمة الرئيسية
        //     $validSubServiceIds = $mainService->children()->pluck('id')->toArray();

        //     foreach ($data['sup_services'] as $sub) {

        //         if (!in_array($sub['id'], $validSubServiceIds)) {
        //             return response()->json([
        //                 'message' => 'إحدى الخدمات الفرعية غير تابعة للخدمة الرئيسية'
        //             ], 422);
        //         }
        //     }
        // }

        // وضح موقع طالب الخدمة اذا كان موقع الطلب فارغ
        if ($mainService->distance_based_price) {
            if (empty($data['latitude']) || empty($data['longitude'])) {
                $userProfile = Auth::user()->profile;
                if ($userProfile) {
                    $data['latitude'] = $userProfile->latitude;
                    $data['longitude'] = $userProfile->longitude;
                }
            }
        }

        $request_id = null;
        DB::transaction(function () use ($data, $mainService, &$request_id) {
            $requestModel = RequestModel::create([
                'user_id' => Auth::user()->id,
                'message' => $data['message'] ?? null,
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'total_price' => 0, // سيتم تحديثه لاحقًا
            ]);
            $request_id = $requestModel->id;
            // تحقق من عدم تكرار إضافة الخدمة الرئيسية
            if (!$requestModel->services()->where('service_id', $data['service_id'])->exists()) {
                $requestModel->services()->attach($data['service_id'], ['quantity' => 1, 'is_main' => true]);
            }

            // Attach main service
            // $requestModel->services()->attach($data['service_id'], ['quantity' =>  1, 'is_main' => true]);


            // تحقق من عدم تكرار إضافة الخدمات الفرعية
            if (!empty($data['sup_services'])) {
                foreach ($data['sup_services'] as $supService) {
                    if (!$requestModel->services()->where('service_id', $supService['id'])->exists()) {
                        $requestModel->services()->attach($supService['id'], [
                            'quantity' => $supService['quantity'],
                            'is_main' => false
                        ]);
                    }
                }
            }

            // Attach supplementary services
            // if (!empty($data['sup_services'])) {
            //     foreach ($data['sup_services'] as $supService) {
            //         $requestModel->services()->attach($supService['id'], ['quantity' => $supService['quantity'], 'is_main' => false]);
            //     }
            // }
            $totalPrice = $mainService->price; // الخدمة الرئيسية دائمًا 1

            // حساب التكلفة بناءً على المسافة إذا كانت مفعلة
            if ($mainService->distance_based_price && isset($data['latitude'], $data['longitude'])) {
                $provider = $mainService->provider;
                $providerLat = $provider->profile->latitude ?? null;
                $providerLng = $provider->profile->longitude ?? null;

                if ($providerLat && $providerLng) {
                    $distance = \App\Helpers\LocationHelper::calculateDistance(
                        $providerLat,
                        $providerLng,
                        $data['latitude'],
                        $data['longitude']
                    );
                    $totalPrice += ($distance * $mainService->price_per_km);
                }
            }

            if (!empty($data['sup_services'])) {
                foreach ($data['sup_services'] as $supService) {
                    $service = Service::find($supService['id']);
                    $totalPrice += $service->price * $supService['quantity'];
                }
            }

            // تحديث الطلب بالسعر النهائي
            $requestModel->update(['total_price' => $totalPrice]);

            // إرسال إشعار للمزود
            $providerId = $mainService->provider_id;
            $this->notificationService->sendToUser(
                $providerId,
                'طلب جديد 🆕',
                'لديك طلب جديد للخدمة ' . $mainService->name . ' من العميل ' . Auth::user()->name,
                \App\Constants\NotificationType::NEW_REQUEST,
                ['request_id' => $requestModel->id]
            );

            // إرسال إشعار تأكيد لطالب الخدمة
            $this->notificationService->sendToUser(
                Auth::id(),
                'تم إرسال طلبك بنجاح 🚀',
                'شكراً لك، تم إرسال طلبك رقم #' . $requestModel->id . ' بنجاح وهو بانتظار موافقة المزود.',
                \App\Constants\NotificationType::GENERAL
            );
        });
        return response()->json([
            'message' => 'تم إنشاء الطلب بنجاح',
            'request_id' => $request_id
        ], 201);
    }

    public function show(Request $request, $request_id)
    {
        $requestModel = RequestModel::with(['user', 'main_service.provider', 'sub_services', 'bonds'])->findOrFail($request_id);
        $requiredPartialAmount = $requestModel->getRequiredPartialAmount();
        $requestModel->required_partial_amount = $requiredPartialAmount;

        return response()->json($requestModel);
    }

    public function getRequestStatus(Request $request, $request_id)
    {
        $requestModel = RequestModel::findOrFail($request_id);
        return response()->json([
            'status' => $requestModel->status,
        ]);
    }

    public function updateStatus(Request $request, $request_id)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', RequestStatus::all()),
        ]);

        $requestModel = RequestModel::findOrFail($request_id);
        // this is authorization
        // I will try it later
        // if (
        //     $data['status'] === RequestStatus::REJECTED ||
        //     $data['status'] === RequestStatus::ACCEPTED_INITIAL ||
        //     $data['status'] === RequestStatus::ACCEPTED_PARTIAL_PAID ||
        //     $data['status'] === RequestStatus::ACCEPTED_FULL_PAID
        // ) {
        //     $this->authorize('updateStatusProvider', $requestModel);
        // }
        // if (
        //     $data['status'] === RequestStatus::CANCELLED ||
        //     $data['status'] === RequestStatus::COMPLETED
        // ) {
        //     $this->authorize('updateStatusSeeker', $requestModel);
        // }
        // if ($data['status'] === RequestStatus::SUSPENDED) {
        //     $this->authorize('updateStatusAdmin', $requestModel);
        // }




        $currentStatus = $requestModel->status;
        $newStatus = $data['status'];

        $allowedTransitions = [
            RequestStatus::PENDING => [
                RequestStatus::CANCELLED,
                RequestStatus::REJECTED,
                RequestStatus::ACCEPTED_INITIAL,
                RequestStatus::SUSPENDED,
            ],
            RequestStatus::ACCEPTED_INITIAL => [
                RequestStatus::CANCELLED,
                RequestStatus::ACCEPTED_PARTIAL_PAID,
                RequestStatus::ACCEPTED_FULL_PAID,
                RequestStatus::SUSPENDED,
            ],
            RequestStatus::ACCEPTED_PARTIAL_PAID => [
                RequestStatus::ACCEPTED_FULL_PAID,
                RequestStatus::SUSPENDED,

            ],
            RequestStatus::ACCEPTED_FULL_PAID => [
                RequestStatus::COMPLETED,
                RequestStatus::SUSPENDED,
            ],
        ];
        if ($currentStatus == RequestStatus::COMPLETED) {
            if (!$requestModel->provider_finished) {
                return response()->json([
                    'message' => 'لا يمكن الانتقال من هذه الحالة إلى الحالة المطلوبة حتى ينتهي المزود من العمل',
                    'currentStatus' => $currentStatus,
                ], 422);
            }
        }


        if (
            !isset($allowedTransitions[$currentStatus]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatus])
        ) {
            return response()->json([
                'message' => 'لا يمكن الانتقال من هذه الحالة إلى الحالة المطلوبة',
                'currentStatus' => $currentStatus,
            ], 422);
        }

        // تحديث الحالة ونقاط المكافأة بشكل ذري
        DB::transaction(
            function () use ($requestModel, $newStatus) {
                $requestModel->update([
                    'status' => $newStatus,
                ]);

                if (in_array($newStatus, [RequestStatus::COMPLETED, RequestStatus::ACCEPTED_FULL_PAID, RequestStatus::ACCEPTED_PARTIAL_PAID])) {
                    // التأكد من تهيئة مبلغ العمولة عند البدء في سداد الطلب أو إكماله لضمان ثبات القيمة
                    if ($requestModel->commission_amount <= 0) {
                        $requestModel->commission_amount = $requestModel->getCommissionAmount();
                        $requestModel->save();
                    }
                }

                if ($newStatus == RequestStatus::COMPLETED) {
                    // 1. منح نقاط مكافأة لطالب الخدمة
                    $this->pointsService->addBonusPoints($requestModel->user_id, $requestModel->id);

                    // 2. محاولة خصم العمولة آلياً من رصيد المزود
                    $this->pointsService->payCommissionFromPoints($requestModel->id);
                }
            }
        );

        // إرسال إشعار للطرف المعني بتحديث الحالة
        $seekerId = $requestModel->user_id;
        $provider = $requestModel->serviceProvider();

        $title = 'تحديث حالة الطلب #' . $requestModel->id;
        $message = '';
        $type = \App\Constants\NotificationType::GENERAL;

        switch ($newStatus) {
            case RequestStatus::ACCEPTED_INITIAL:
                $message = 'تم قبول طلبك مبدئياً من قبل المزود، يمكنك الآن متابعة الدفع.';
                $type = \App\Constants\NotificationType::REQUEST_ACCEPTED;
                $this->notificationService->sendToUser($seekerId, $title, $message, $type, ['request_id' => $requestModel->id]);
                break;
            case RequestStatus::REJECTED:
                $message = 'نعتذر، تم رفض طلبك من قبل المزود.';
                $type = \App\Constants\NotificationType::REQUEST_REJECTED;
                $this->notificationService->sendToUser($seekerId, $title, $message, $type, ['request_id' => $requestModel->id]);
                break;
            case RequestStatus::COMPLETED:
                $message = 'تم اكتمال طلبك بنجاح، شكراً لتعاملك معنا.';
                $type = \App\Constants\NotificationType::REQUEST_COMPLETED;
                $this->notificationService->sendToUser($seekerId, $title, $message, $type, ['request_id' => $requestModel->id]);
                break;
            case RequestStatus::CANCELLED:
                // إبلاغ الطرف الآخر بالإلغاء
                $cancelledBy = Auth::id();
                $targetId = ($cancelledBy == $seekerId) ? $provider->id : $seekerId;
                $message = 'تم إلغاء الطلب من قبل الطرف الآخر.';
                $this->notificationService->sendToUser($targetId, $title, $message, $type, ['request_id' => $requestModel->id]);
                break;
        }

        $requestModel = RequestModel::with([
            'user',
            'main_service',
            'sub_services',
            'bonds',
        ])->find($requestModel->id);

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح',
            'request' => $requestModel,
        ]);
    }

    public function finishRequest($request_id)
    {
        $requestModel = RequestModel::findOrFail($request_id);

        // التحقق من أن المستخدم هو مزود الخدمة لهذا الطلب
        $provider = $requestModel->serviceProvider();
        if (!$provider || $provider->id !== Auth::id()) {
            return response()->json(['message' => 'غير مصرح لك بإنهاء هذا الطلب'], 403);
        }

        // التحقق من حالة الطلب (accepted_full_paid OR accepted_partial_paid)
        $allowedStatuses = [RequestStatus::ACCEPTED_FULL_PAID, RequestStatus::ACCEPTED_PARTIAL_PAID];
        if (!in_array($requestModel->status, $allowedStatuses)) {
            return response()->json(['message' => 'لا يمكن إنهاء الطلب إلا إذا كان في حالة دفع كامل أو جزئي'], 422);
        }

        $requestModel->update(['provider_finished' => true]);

        // إشعار لطالب الخدمة
        $this->notificationService->sendToUser(
            $requestModel->user_id,
            'أنهى المزود العمل ✅',
            'لقد حدد المزود الطلب كمكتمل من طرفه، يرجى مراجعة العمل وتأكيد الاستلام.',
            \App\Constants\NotificationType::REQUEST_COMPLETED,
            ['request_id' => $requestModel->id]
        );

        return response()->json([
            'message' => 'تم تحديد الطلب كمكتمل من قبل المزود بنجاح',
            'request' => $requestModel
        ]);
    }

    public function payByPoints(Request $request, $request_id)
    {
        $data = $request->validate([
            'transferred_points' => 'required|numeric|min:0.01',
        ]);
        $request = RequestModel::findOrFail($request_id);
        if($request->status !== RequestStatus::ACCEPTED_INITIAL &&$request->status !== RequestStatus::ACCEPTED_PARTIAL_PAID && $request->status !== RequestStatus::ACCEPTED_FULL_PAID) {
            return response()->json(['message' => 'لا يمكن الدفع إلا إذا كان في حالة دفع جزئي'], 422);
        }

        $requestModel = RequestModel::findOrFail($request_id);

        if ($requestModel->user_id !== Auth::id()) {
            return response()->json(['message' => 'غير مصرح للقيام بعملية الدفع لهذا الطلب'], 403);
        }

        try {
            $updatedRequest = $this->pointsService->payRequest($request_id, $data['transferred_points']);

            // إشعار للمزود باستلام دفع
            $provider = $requestModel->serviceProvider();
            $this->notificationService->sendToUser(
                $provider->id,
                'تم استلام دفعة نقاط 💰',
                'لقد استلمت ' . $data['transferred_points'] . ' نقطة كدفعة للطلب #' . $requestModel->id,
                \App\Constants\NotificationType::POINTS_RECEIVED,
                ['request_id' => $requestModel->id]
            );

            return response()->json([
                'message' => 'تم الدفع بنجاح',
                'request' => $updatedRequest
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function addAmountToMoneyPaid(Request $request, $request_id)
    {
        $data = $request->validate([
            'added_amount' => 'required|numeric|min:1',
        ]);

        $requestModel = RequestModel::findOrFail($request_id);

        if ($requestModel->serviceProvider()->id !== Auth::id()) {
            return response()->json(['message' => 'غير مصرح للقيام بعملية الدفع لهذا الطلب'], 403);
        }

        try {
            $updatedRequest = $this->requestService->addToMoneyPaid($request_id, $data['added_amount']);

            return response()->json([
                'message' => 'تم الدفع بنجاح',
                'request' => $updatedRequest
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function payCommissionByPoints($id)
    {
        $requestModel = RequestModel::findOrFail($id);

        // التحقق من أن المستخدم هو مزود الخدمة لهذا الطلب
        $provider = $requestModel->serviceProvider();
        if (!$provider || $provider->id !== Auth::id()) {
            return response()->json(['message' => 'غير مصرح لك بدفع عمولة هذا الطلب'], 403);
        }

        if ($requestModel->status !== RequestStatus::COMPLETED) {
            return response()->json(['message' => 'لا يمكن دفع العمولة إلا للطلبات المكتملة'], 422);
        }

        try {
            $updatedRequest = $this->pointsService->payCommissionFromPoints($id);
            return response()->json([
                'message' => 'تمت عملية دفع العمولة بنجاح',
                'request' => $updatedRequest
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    //web functions
    public function indexAdmin(Request $httpRequest, RequestService $service)
    {
        $data = $service->getAllRequests($httpRequest);
        return view('requests.index', ['requests' => $data['requests'], 'stats' => $data['stats']]);
    }

    public function showAdmin($id)
    {
        $request = \App\Models\Request::with([
            'user',
            'services',
            'commissionBonds'
        ])->findOrFail($id);

        $commission = $request->getCommissionAmount();

        return view('requests.show', ['request' => $request, 'commission' => $commission]);
    }

    public function markPaid($request_id, RequestService $service)
    {
        $requestModel = RequestModel::findOrFail($request_id);
        if ($requestModel->status !== RequestStatus::COMPLETED && $requestModel->status !== RequestStatus::ACCEPTED_FULL_PAID && $requestModel->status !== RequestStatus::ACCEPTED_PARTIAL_PAID)
            return back()->withErrors('لا يمكن اتمام هذه العملية لان الطلب لم يتم الدفع له');

        $this->authorize('markPaid', $requestModel);
        $service->markPaid($requestModel);
        return back()->with('success', 'تم تحديد الطلب كمدفوع');
    }
}
