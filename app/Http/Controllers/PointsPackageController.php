<?php

namespace App\Http\Controllers;

use App\Services\PointsPackageService;
use Illuminate\Http\Request;

class PointsPackageController extends Controller
{
    public function __construct(private PointsPackageService $service) {}

    public function index()
    {
        return response()->json($this->service->getAllPackages(true));
    }

    public function store(Request $request)
    {
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
        $data = $request->validate([
            'name' => 'nullable|string',
            'points' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'bonus_points' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return response()->json(['message' => 'تم حذف الباقة بنجاح']);
    }

    public function toggleStatus($id)
    {
        return response()->json($this->service->toggleStatus($id));
    }

    // Web Admin Methods
    public function indexWeb()
    {
        $packages = $this->service->getAllPackages(true);
        return view('admin.points_packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.points_packages.create');
    }

    public function storeWeb(Request $request)
    {
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
        $package = \App\Models\PointsPackage::findOrFail($id);
        return view('admin.points_packages.edit', compact('package'));
    }

    public function updateWeb(Request $request, $id)
    {
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
        $this->service->destroy($id);
        return redirect()->route('admin.points-packages.index')->with('success', 'تم حذف الباقة بنجاح');
    }
}
