<?php

namespace App\Http\Controllers;

use App\Services\UserPointsPackageService;
use App\Services\PointsPackageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPointsPackageController extends Controller
{
    public function __construct(
        private UserPointsPackageService $userPackageService,
        private PointsPackageService $packageService
    ) {}

    // User: Get available packages
    public function availablePackages()
    {
        return response()->json($this->packageService->getAllPackages(false));
    }

    // User: Get specific package details
    public function show($id)
    {
        return response()->json($this->packageService->getPackage($id));
    }

    // User: Get my packages (subscriptions)
    public function myPackages()
    {
        return response()->json($this->userPackageService->getUserPackages(Auth::id()));
    }

    // User: Subscribe to a package
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'package_id' => 'required|exists:points_packages,id',
            'bond_number' => 'required|string',
            'bank_name' => 'required|string',
            'bond_image' => 'required|image|max:2048',
        ]);

        $subscription = $this->userPackageService->purchase(
            Auth::id(),
            $data,
            $request->file('bond_image')
        );

        return response()->json([
            'message' => 'تم إرسال طلب الاشتراك بنجاح وهو بانتظار المراجعة',
            'data' => $subscription
        ], 201);
    }

    // Admin: List all subscription requests
    public function index(Request $request)
    {
        return response()->json($this->userPackageService->index($request->status));
    }

    // Admin: Approve
    public function approve($id)
    {
        try {
            $result = $this->userPackageService->approve($id, Auth::id());
            return response()->json([
                'message' => 'تمت الموافقة على الطلب وإضافة النقاط للمستخدم',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    // Admin: Reject
    public function reject(Request $request, $id)
    {
        $request->validate(['admin_note' => 'required|string']);
        
        try {
            $result = $this->userPackageService->reject($id, Auth::id(), $request->admin_note);
            return response()->json([
                'message' => 'تم رفض طلب الاشتراك',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    // Web Admin Methods
    public function indexWeb(Request $request)
    {
        $subscriptions = $this->userPackageService->index($request->status);
        return view('admin.user_points_packages.index', compact('subscriptions'));
    }

    public function showWeb($id)
    {
        $subscription = \App\Models\UserPointsPackage::with(['user', 'package', 'admin'])->findOrFail($id);
        return view('admin.user_points_packages.show', compact('subscription'));
    }

    public function approveWeb($id)
    {
        try {
            $this->userPackageService->approve($id, Auth::id());
            return redirect()->back()->with('success', 'تمت الموافقة على الطلب وإضافة النقاط للمستخدم');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function rejectWeb(Request $request, $id)
    {
        $request->validate(['admin_note' => 'required|string']);
        
        try {
            $this->userPackageService->reject($id, Auth::id(), $request->admin_note);
            return redirect()->route('admin.user-points-packages.index')->with('success', 'تم رفض طلب الاشتراك');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
