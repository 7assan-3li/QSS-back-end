<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserVerificationPackageRequest;
use App\Services\UserVerificationPackagesService;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class UserVerificationPackagesController extends Controller
{

    public function __construct(
        private UserVerificationPackagesService $verificationPackageService,
        private NotificationService $notificationService
    ) {}

    public function index()
    {
        $userPackages = $this->verificationPackageService->getUserPackages(Auth::id());
        return response()->json(['user_packages' => $userPackages]);
    }

    public function indexAdmin()
    {
        $userPackages = $this->verificationPackageService->getAllPackages();
        return response()->json(['user_packages' => $userPackages]);
    }

    public function store(StoreUserVerificationPackageRequest $request)
    {
        // حماية النظام: منع شراء الباقات لمن لم يسبق قبول توثيق هويتهم الأساسية ولو لمرة واحدة
        $hasApprovedIdentity = \App\Models\VerificationRequest::where('user_id', Auth::id())
            ->where('status', 'accepted')
            ->exists();

        if (!$hasApprovedIdentity) {
            return response()->json([
                'message' => 'عذراً، لا يُسمح لك بشراء باقات التوثيق الممتدة إلا بعد تقديم طلب توثيق الهوية الأساسي والموافقة عليه من قبل الإدارة.'
            ], 403);
        }

        $validated = $request->validated();
        $imageFile = $request->file('image_bond');

        $userPackage = $this->verificationPackageService->storePackage(Auth::id(), $validated, $imageFile);

        // إشعار تأكيد استلام طلب الاشتراك
        $this->notificationService->sendToUser(
            Auth::id(),
            'طلب اشتراك باقة التوثيق 🎫',
            'تم استلام طلب اشتراكك في الباقة بنجاح، وهو الآن قيد المراجعة.',
            \App\Constants\NotificationType::ADMIN_MSG
        );

        return response()->json([
            'message' => 'تم إرسال طلب الاشتراك بنجاح، بانتظار موافقة المسؤول',
            'user_package' => $userPackage
        ]);
    }

    public function approve($id)
    {
        $userPackage = $this->verificationPackageService->approvePackage($id, Auth::id());

        // إشعار بقبول باقة التوثيق
        $this->notificationService->sendToUser(
            $userPackage->user_id,
            'تفعيل باقة التوثيق ✨',
            'تمت الموافقة على اشتراكك وتفعيل ميزات باقة التوثيق بنجاح.',
            \App\Constants\NotificationType::ADMIN_MSG
        );

        return response()->json([
            'message' => 'تم الموافقة على الطلب بنجاح',
            'user_package' => $userPackage
        ]);
    }

    public function reject(Request $request, $id)
    {
        $userPackage = $this->verificationPackageService->rejectPackage($id, Auth::id(), $request->input('rejection_reason'));

        // إشعار برفض باقة التوثيق
        $this->notificationService->sendToUser(
            $userPackage->user_id,
            'رفض اشتراك باقة التوثيق ⚠️',
            'للأسف، تم رفض طلب اشتراكك في باقة التوثيق. السبب: ' . ($request->input('rejection_reason') ?? 'يرجى مراجعة البيانات.'),
            \App\Constants\NotificationType::ADMIN_MSG
        );

        return response()->json([
            'message' => 'تم رفض الطلب',
            'user_package' => $userPackage
        ]);
    }

    public function show($id)
    {
        $userPackage = $this->verificationPackageService->getPackageDetails($id);
        return response()->json(['user_package' => $userPackage]);
    }

    // Web Admin Methods
    public function indexWebAdmin()
    {
        $userPackages = $this->verificationPackageService->getAllPackages();
        return view('user_verification_packages.index', compact('userPackages'));
    }

    public function showWebAdmin($id)
    {
        $userPackage = $this->verificationPackageService->getPackageDetails($id);
        return view('user_verification_packages.show', compact('userPackage'));
    }

    public function approveWebAdmin($id)
    {
        $this->verificationPackageService->approvePackage($id, Auth::id());
        return redirect()->back()->with('success', 'تم الموافقة على الطلب بنجاح');
    }

    public function rejectWebAdmin(Request $request, $id)
    {
        $this->verificationPackageService->rejectPackage($id, Auth::id(), $request->input('rejection_reason'));
        return redirect()->back()->with('success', 'تم رفض الطلب بنجاح');
    }
}
