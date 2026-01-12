<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();
        $services = $user->services()
            ->with(['category', 'children'])
            ->get();
        return response()->json($services);
    }
    public function store(Request $request)
    {
        $this->authorize('create', Service::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'parent_service_id' => 'nullable|exists:services,id',
            'status' => 'nullable|string|in:available,unavailable',
            'image_path' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'is_available' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'distance_based_price' => 'nullable|boolean',
            'price_per_km' => 'nullable|numeric|min:0',
        ]);

        // إضافة provider_id تلقائيًا من المستخدم الحالي
        $validated['provider_id'] = Auth::user()->id;

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')
                ->store('services', 'public');
        }

        // إنشاء الخدمة
        $service = Service::create($validated);

        return response()->json([
            'message' => 'Service created successfully',
            'data' => $service
        ], 201);
    }

    public function show(Service $service)
    {
        $this->authorize('view', $service);

        return response()->json($service);
    }

    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'parent_service_id' => 'sometimes|nullable|exists:services,id',
            'status' => 'sometimes|nullable|string|in:available,unavailable',
            'image_path' => 'sometimes|nullable|string|max:255',
            'is_available' => 'sometimes|nullable|boolean',
            'is_active' => 'sometimes|nullable|boolean',
            'distance_based_price' => 'sometimes|nullable|boolean',
            'price_per_km' => 'sometimes|nullable|numeric|min:0',
        ]);

        $service->update($validated);

        return response()->json([
            'message' => 'Service updated successfully',
            'data' => $service
        ]);
    }
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        $service->delete();
        return response()->json([
            'message' => 'Service deleted successfully'
        ]);
    }

    public function storeChild(Request $request)
    {
        $this->authorize('create', Service::class);
        $validated = $request->validate([
            'parent_service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        // إضافة provider_id تلقائيًا من المستخدم الحالي
        $validated['provider_id'] = Auth::user()->id;

        // إنشاء الخدمة الفرعية
        $childService = Service::create($validated);

        return response()->json([
            'message' => 'Child service created successfully',
            'data' => $childService
        ], 201);
    }


    //web functions
    public function adminIndex()
    {
        $this->authorize('viewAny', User::class);

        $services = Service::with(['category', 'provider'])->latest()->where('parent_service_id', null)->get();
        $stats = [
            'total' => Service::where('parent_service_id', null)->count(),
            'available' => Service::where('is_available', true)->where('parent_service_id', null)->count(),
            'unavailable' => Service::where('is_available', false)->where('parent_service_id', null)->count(),
            'active' => Service::where('is_active', true)->where('parent_service_id', null)->count(),
        ];

        return view('services.index', compact('services', 'stats'));
    }

    public function adminShow(Service $service)
    {
        $service->load(['provider', 'category', 'parent', 'children'])->where('parent_service_id', null);

        return view('services.show', ['service' => $service]);
    }
}
