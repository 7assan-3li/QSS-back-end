<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserVerificationPackageRequest;
use App\Services\UserVerificationPackagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserVerificationPackagesController extends Controller
{
    protected $verificationPackageService;

    public function __construct(UserVerificationPackagesService $verificationPackageService)
    {
        $this->verificationPackageService = $verificationPackageService;
    }

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
        $validated = $request->validated();
        $imageFiles = $request->hasFile('image_bonds') ? $request->file('image_bonds') : [];

        $userPackage = $this->verificationPackageService->storePackage(Auth::id(), $validated, $imageFiles);

        return response()->json([
            'message' => 'تم إرسال طلب الاشتراك بنجاح، بانتظار موافقة المسؤول',
            'user_package' => $userPackage
        ]);
    }

    public function approve($id)
    {
        $userPackage = $this->verificationPackageService->approvePackage($id, Auth::id());

        return response()->json([
            'message' => 'تم الموافقة على الطلب بنجاح',
            'user_package' => $userPackage
        ]);
    }

    public function reject($id)
    {
        $userPackage = $this->verificationPackageService->rejectPackage($id, Auth::id());

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

    public function rejectWebAdmin($id)
    {
        $this->verificationPackageService->rejectPackage($id, Auth::id());
        return redirect()->back()->with('success', 'تم رفض الطلب');
    }
}
