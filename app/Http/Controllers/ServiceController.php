<?php

namespace App\Http\Controllers;

use App\constant\ServiceType;
use App\Models\Service;
use App\Models\User;
use App\Services\ServiceService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    use AuthorizesRequests;

    public function search(Request $request)
    {
        $queryText = $request->input('query');
        $categoryId = $request->input('category_id');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $servicesQuery = Service::where('type', ServiceType::MAIN)
            ->where('is_active', true)
            ->with(['provider.profile', 'category', 'children']);

        // 1. Text Search (Name, Description, Hierarchical Category, Children)
        if ($queryText) {
            // Find all categories that match the query and their descendants
            $matchedCategories = \App\Models\Category::where('name', 'LIKE', "%{$queryText}%")->get();
            $categoryIds = [];
            foreach ($matchedCategories as $cat) {
                $categoryIds = array_merge($categoryIds, \App\Models\Category::getAllChildrenIds($cat->id));
            }
            $categoryIds = array_unique($categoryIds);

            $servicesQuery->where(function ($q) use ($queryText, $categoryIds) {
                $q->where('name', 'LIKE', "%{$queryText}%")
                    ->orWhere('description', 'LIKE', "%{$queryText}%")
                    ->orWhereIn('category_id', $categoryIds)
                    ->orWhereHas('children', function ($sq) use ($queryText) {
                        $sq->where('name', 'LIKE', "%{$queryText}%");
                    });
            });
        }

        // 2. Hierarchical Category Filter
        if ($categoryId) {
            $allCategoryIds = \App\Models\Category::getAllChildrenIds($categoryId);
            $servicesQuery->whereIn('category_id', $allCategoryIds);
        }

        // 3. Price Filter
        if ($minPrice) {
            $servicesQuery->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $servicesQuery->where('price', '<=', $maxPrice);
        }

        $services = $servicesQuery->get();

        // 4. Calculate Availability and Distance
        $services->map(function ($service) use ($lat, $lng) {
            $service->is_available_now = $service->isAvailableNow();
            
            if ($lat && $lng && $service->provider && $service->provider->profile) {
                $pLat = $service->provider->profile->latitude;
                $pLng = $service->provider->profile->longitude;
                
                if ($pLat && $pLng) {
                    $service->distance = $this->calculateDistance($lat, $lng, $pLat, $pLng);
                } else {
                    $service->distance = null;
                }
            } else {
                $service->distance = null;
            }
            return $service;
        });

        // 5. Sort by Distance if coordinates provided
        if ($lat && $lng) {
            $services = $services->sortBy('distance')->values();
        }

        return response()->json([
            'message' => 'Search results retrieved successfully',
            'count' => $services->count(),
            'data' => $services
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
    public function index()
    {
        $user = Auth::user();
        $services = $user->services()
            ->with(['category', 'children'])->where('type', ServiceType::MAIN)->where('parent_service_id', null)
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
            'image_path' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240',
            'is_available' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'distance_based_price' => 'nullable|boolean',
            'price_per_km' => 'nullable|numeric|min:0',
            'required_partial_percentage' => 'required|integer|min:0|max:100',
        ]);

        // إضافة provider_id تلقائيًا من المستخدم الحالي
        $validated['provider_id'] = Auth::user()->id;
        $validated['type'] = ServiceType::MAIN;

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
        // $this->authorize('view', $service);
        $requiredPartialAmount = $service->getRequiredPartialAmount();
        $service->required_partial_amount = $requiredPartialAmount;

        // إضافة معلومة التوفر الحالي
        $service->setAttribute('is_available_now', $service->isAvailableNow());

        // جلب التقييمات والمراجعات الخاصة بهذه الخدمة
        $reviews = \App\Models\Review::whereHas('request.services', function($q) use ($service) {
                $q->where('service_id', $service->id);
            })
            ->where('is_hidden', false)
            ->with(['request.user.profile'])
            ->latest()
            ->get();

        $service->setAttribute('reviews', \App\Http\Resources\ReviewResource::collection($reviews));

        return response()->json([
            'message' => 'Service retrieved successfully',
            'data' => $service->load(['category', 'children', 'schedules.days', 'provider.profile'])
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $validated = $request->validate([
            'name'                        => 'sometimes|required|string|max:255',
            'description'                 => 'sometimes|nullable|string',
            'price'                       => 'sometimes|required|numeric|min:0',
            'status'                      => 'sometimes|nullable|string|in:available,unavailable',
            'is_active'                   => 'sometimes|boolean',
            'distance_based_price'        => 'sometimes|boolean',
            'price_per_km'                => 'required_if:distance_based_price,true|nullable|numeric|min:0',
            'required_partial_percentage' => 'sometimes|integer|min:0|max:100',
        ]);

        if ($request->hasFile('image_path')) {
            if ($service->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($service->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('services', 'public');
        }

        $service->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Service updated successfully',
            'data'    => $service->load(['category', 'children'])
        ]);
    }

    public function adminUpdate(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $validated = $request->validate([
            'name'                        => 'required|string|max:255',
            'description'                 => 'nullable|string',
            'price'                       => 'required|numeric|min:0',
            'category_id'                 => 'required|exists:categories,id',
            'provider_id'                 => 'required|exists:users,id',
            'status'                      => 'required|string|in:available,unavailable',
            'is_active'                   => 'sometimes|boolean',
            'is_available'                => 'sometimes|boolean',
            'distance_based_price'        => 'sometimes|boolean',
            'price_per_km'                => 'required_if:distance_based_price,1|nullable|numeric|min:0',
            'required_partial_percentage' => 'required|integer|min:0|max:100',
            'image_path'                  => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);

        if ($request->hasFile('image_path')) {
            if ($service->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($service->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('services', 'public');
        }

        // Toggles handling
        $validated['is_active'] = $request->has('is_active');
        $validated['is_available'] = $request->has('is_available');
        $validated['distance_based_price'] = $request->has('distance_based_price');

        $service->update($validated);

        return redirect()->route('services.show', $service->id)->with('success', __('تم تحديث بيانات الخدمة بواسطة المسؤول بنجاح'));
    }
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        if ($service->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($service->image_path);
        }

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

        $parentService = Service::findOrFail($validated['parent_service_id']);

        // إضافة provider_id, category_id, و type تلقائيًا من الخدمة الأب أو المستخدم
        $validated['provider_id'] = Auth::user()->id;
        $validated['category_id'] = $parentService->category_id;
        $validated['type'] = ServiceType::CHILD;


        // إنشاء الخدمة الفرعية
        $childService = Service::create($validated);

        return response()->json([
            'message' => 'Child service created successfully',
            'data' => $childService
        ], 201);
    }

    public function updateChild(Request $request, Service $childService)
    {
        $this->authorize('update', $childService);

        // Ensure the service is actually a child service
        if ($childService->type !== ServiceType::CHILD) {
            return response()->json(['message' => 'This service is not a child service'], 400);
        }

        $rules = [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
        ];



        $validated = $request->validate($rules);



        $childService->update($validated);

        return response()->json([
            'message' => 'Child service updated successfully',
            'data' => $childService
        ]);
    }

    public function deleteChild(Service $childService)
    {
        $this->authorize('delete', $childService);

        // Ensure the service is actually a child service
        if ($childService->type !== ServiceType::CHILD) {
            return response()->json(['message' => 'This service is not a child service'], 400);
        }


        $childService->delete();

        return response()->json([
            'message' => 'Child service deleted successfully'
        ]);
    }

    public function updateByType(Request $request, $type)
    {
        if (!in_array($type, [ServiceType::CUSTOM, ServiceType::MEETING])) {
            return response()->json(['message' => 'Invalid service type'], 400);
        }

        $service = Auth::user()->services()->where('type', $type)->first();

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $this->authorize('update', $service);

        $rules = [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'sometimes|nullable|string|in:available,unavailable',
            'is_available' => 'sometimes|nullable|boolean',
            'is_active' => 'sometimes|nullable|boolean',
            'distance_based_price' => 'sometimes|nullable|boolean',
            'price_per_km' => 'sometimes|nullable|numeric|min:0',
        ];

        // if ($request->hasFile('image_path')) {
        //     $rules['image_path'] = 'image|mimes:png,jpg,jpeg,webp|max:2048';
        // } else {
        //     $rules['image_path'] = 'sometimes|nullable|string|max:255';
        // }

        $validated = $request->validate($rules);

        // if ($request->hasFile('image_path')) {
        //     if ($service->image_path) {
        //         \Illuminate\Support\Facades\Storage::disk('public')->delete($service->image_path);
        //     }
        //     $validated['image_path'] = $request->file('image_path')->store('services', 'public');
        // }

        $service->update($validated);

        return response()->json([
            'message' => ucfirst($type) . ' service updated successfully',
            'data' => $service
        ]);
    }

    public function showAll()
    {
        $services = Service::where('type', ServiceType::MAIN)->with('provider')->get();
        return response()->json($services, 200);
    }

    public function getTopRequestedServices(Request $request)
    {
        $limit = $request->input('limit', 10); // Number of services to return
        
        $services = Service::where('type', ServiceType::MAIN)
            ->with(['provider', 'category'])
            ->withCount('requests')
            ->orderByDesc('requests_count')
            ->take($limit)
            ->get();
            
        return response()->json($services, 200);
    }




    //web functions
    public function adminIndex()
    {
        $this->authorize('viewAny', User::class);

        $services = Service::with(['category', 'provider', 'children'])->latest()->where('parent_service_id', null)->paginate(10);
        $stats = [
            'total' => Service::where('parent_service_id', null)->count(),
            'available' => Service::where('is_available', true)->where('parent_service_id', null)->count(),
            'unavailable' => Service::where('is_available', false)->where('parent_service_id', null)->count(),
            'active' => Service::where('is_active', true)->where('parent_service_id', null)->count(),
            'meeting_service' => Service::where('type', ServiceType::MEETING)->count(),
            'custom_service' => Service::where('type', ServiceType::CUSTOM)->count(),
        ];

        return view('services.index', compact('services', 'stats'));
    }

    public function adminShow(Service $service)
    {
        $service->load(['provider', 'category', 'parent', 'children', 'requests' => function($q) {
            $q->with(['user', 'review']);
        }]);

        // Calculate Analytical KPIs for the Service
        $stats = [
            'total_requests' => $service->requests()->count(),
            'completed_requests' => $service->requests()->where('status', 'completed')->count(),
            'total_revenue' => $service->requests()->where('status', 'completed')->sum('total_price'),
            'total_commissions' => $service->requests()->where('commission_paid', true)->sum('commission_amount'),
            'average_rating' => \App\Models\Review::whereHas('request.services', function($q) use ($service) {
                $q->where('service_id', $service->id);
            })->avg('rating') ?: 0,
        ];

        // Get recent reviews for this service
        $recentReviews = \App\Models\Review::whereHas('request.services', function($q) use ($service) {
            $q->where('service_id', $service->id);
        })->with('request.user')->latest()->limit(10)->get();

        return view('services.show', compact('service', 'stats', 'recentReviews'));
    }

    public function edit(Service $service)
    {
        $this->authorize('update', $service);
        $service->load(['category', 'provider', 'children']);
        $categories = \App\Models\Category::all();
        $providers = \App\Models\User::where('role', 'provider')->get();

        return view('services.edit', compact('service', 'categories', 'providers'));
    }
}
