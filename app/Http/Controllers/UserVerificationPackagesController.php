<?php

namespace App\Http\Controllers;

use App\Models\UserVerificationPackages;
use App\Http\Requests\StoreUserVerificationPackageRequest;
use App\constant\BondStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserVerificationPackagesController extends Controller
{
    public function index()
    {
        $userPackages = UserVerificationPackages::with('verificationPackage')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return response()->json(['user_packages' => $userPackages]);
    }

    public function indexAdmin()
    {
        $userPackages = UserVerificationPackages::with(['user', 'verificationPackage', 'admin'])
            ->latest()
            ->get();
        return response()->json(['user_packages' => $userPackages]);
    }

    public function store(StoreUserVerificationPackageRequest $request)
    {
        $validated = $request->validated();
        
        if ($request->hasFile('image_bond')) {
            $validated['image_bond'] = $request->file('image_bond')
                ->store('verification_bonds', 'public');
        }

        $userPackage = UserVerificationPackages::create([
            'user_id' => Auth::id(),
            'verification_package_id' => $validated['verification_package_id'],
            'image_bond' => $validated['image_bond'],
            'number_bond' => $validated['number_bond'],
            'status' => BondStatus::PENDING,
        ]);

        return response()->json([
            'message' => 'تم إرسال طلب الاشتراك بنجاح، بانتظار موافقة المسؤول',
            'user_package' => $userPackage
        ]);
    }

    public function approve($id)
    {
        $userPackage = UserVerificationPackages::findOrFail($id);
        $userPackage->update([
            'status' => BondStatus::APPROVED,
            'admin_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'تم الموافقة على الطلب بنجاح',
            'user_package' => $userPackage
        ]);
    }

    public function reject($id)
    {
        $userPackage = UserVerificationPackages::findOrFail($id);
        $userPackage->update([
            'status' => BondStatus::REJECTED,
            'admin_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'تم رفض الطلب',
            'user_package' => $userPackage
        ]);
    }

    public function show($id)
    {
        $userPackage = UserVerificationPackages::with(['user', 'verificationPackage', 'admin'])
            ->findOrFail($id);
        return response()->json(['user_package' => $userPackage]);
    }
}
