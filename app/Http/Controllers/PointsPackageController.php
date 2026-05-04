<?php

namespace App\Http\Controllers;

use App\Models\PointsPackage;
use App\Services\PointsPackageService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PointsPackageController extends Controller
{
    use AuthorizesRequests;
    public function __construct(private PointsPackageService $service)
    {
    }

    public function index()
    {
        return response()->json($this->service->getAllPackages(true));
    }

    public function store(Request $request)
    {
        $this->authorize('create', PointsPackage::class);
        $data = $request->validate([
            'name' => 'required|string',
            'points' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'bonus_points' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date',
        ]);

        return response()->json($this->service->store($data), 201);
    }

    public function update(Request $request, $id)
    {
        $package = PointsPackage::findOrFail($id);
        $this->authorize('update', $package);

        $data = $request->validate([
            'name' => 'nullable|string',
            'points' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'bonus_points' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);
        $points_package = $this->service->update($id, $data);
        return response()->json($points_package);
    }

    public function destroy($id)
    {
        $package = PointsPackage::findOrFail($id);
        $this->authorize('delete', $package);
        $this->service->destroy($id);
        return response()->json(['message' => 'تم حذف الباقة بنجاح']);
    }

    public function toggleStatus($id)
    {
        $package = PointsPackage::findOrFail($id);
        $this->authorize('update', $package);
        $points_package = $this->service->toggleStatus($id);
        return response()->json([$points_package,'message' => 'تم تبديل حالة الباقة بنجاح']);
    }

    // Web Admin Methods
    public function indexWeb()
    {
        $this->authorize('viewAny', PointsPackage::class);
        $packages = $this->service->getAllPackages(true);
        return view('admin.points_packages.index', compact('packages'));
    }

    public function create()
    {
        $this->authorize('create', PointsPackage::class);
        return view('admin.points_packages.create');
    }

    public function storeWeb(Request $request)
    {
        $this->authorize('create', PointsPackage::class);
        $data = $request->validate([
            'name' => 'required|string',
            'points' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'bonus_points' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date',
        ]);

        $this->service->store($data);
        return redirect()->route('admin.points-packages.index')->with('success', 'تم إضافة الباقة بنجاح');
    }

    public function edit($id)
    {
        $package = PointsPackage::findOrFail($id);
        $this->authorize('update', $package);
        return view('admin.points_packages.edit', compact('package'));
    }

    public function updateWeb(Request $request, $id)
    {
        $package = PointsPackage::findOrFail($id);
        $this->authorize('update', $package);
        $data = $request->validate([
            'name' => 'nullable|string',
            'points' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'bonus_points' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $this->service->update($id, $data);
        return redirect()->route('admin.points-packages.index')->with('success', 'تم تحديث الباقة بنجاح');
    }

    public function destroyWeb($id)
    {
        $package = PointsPackage::findOrFail($id);
        $this->authorize('delete', $package);
        $this->service->destroy($id);
        return redirect()->route('admin.points-packages.index')->with('success', 'تم حذف الباقة بنجاح');
    }
}
