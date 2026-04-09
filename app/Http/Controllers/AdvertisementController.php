<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::orderBy('sort_order', 'asc')->paginate(10);
        
        // Comprehensive Statistics for Reporting
        $stats = [
            'total' => Advertisement::count(),
            'active' => Advertisement::where('is_active', true)->count(),
            'views' => Advertisement::sum('views_count'),
            'clicks' => Advertisement::sum('clicks_count'),
        ];
        
        return view('admin.advertisements.index', compact('advertisements', 'stats'));
    }

    /**
     * Show the form for creating a new advertisement.
     */
    public function create()
    {
        $categories = Category::all();
        $services = Service::all();
        return view('admin.advertisements.create', compact('categories', 'services'));
    }

    /**
     * Store a newly created advertisement in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'type' => 'required|in:carousel,popup,section',
            'target_type' => 'required|in:service,category,external,none',
            'target_id' => 'nullable|integer',
            'external_link' => 'nullable|url',
            'user_type' => 'required|in:all,client,provider',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'required|integer|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('advertisements', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Advertisement::create($validated);

        return redirect()->route('advertisements.index')->with('success', __('تم إضافة الإعلان بنجاح'));
    }

    /**
     * Show the form for editing the specified advertisement.
     */
    public function edit(Advertisement $advertisement)
    {
        $categories = Category::all();
        $services = Service::all();
        return view('admin.advertisements.edit', compact('advertisement', 'categories', 'services'));
    }

    /**
     * Update the specified advertisement in storage.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'type' => 'required|in:carousel,popup,section',
            'target_type' => 'required|in:service,category,external,none',
            'target_id' => 'nullable|integer',
            'external_link' => 'nullable|url',
            'user_type' => 'required|in:all,client,provider',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'required|integer|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        if ($request->hasFile('image_path')) {
            // Delete old image
            if ($advertisement->image_path) {
                Storage::disk('public')->delete($advertisement->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('advertisements', 'public');
        } else {
            // Keep the old image path if no new file is uploaded
            unset($validated['image_path']);
        }

        $validated['is_active'] = $request->has('is_active');

        $advertisement->update($validated);

        return redirect()->route('advertisements.index')->with('success', __('تم تحديث الإعلان بنجاح'));
    }

    /**
     * Remove the specified advertisement from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->image_path) {
            Storage::disk('public')->delete($advertisement->image_path);
        }
        $advertisement->delete();

        return redirect()->route('advertisements.index')->with('success', __('تم حذف الإعلان بنجاح'));
    }

    /**
     * API: Get active advertisements for the app.
     */
    public function getAds(Request $request)
    {
        $userType = $request->query('user_type', 'all');
        
        $ads = Advertisement::active()
            ->forUserType($userType)
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $ads->map(function ($ad) {
                return [
                    'id' => $ad->id,
                    'title' => $ad->title,
                    'image_url' => asset('storage/' . $ad->image_path),
                    'type' => $ad->type,
                    'target_type' => $ad->target_type,
                    'target_id' => $ad->target_id,
                    'external_link' => $ad->external_link,
                    'metrics' => [
                        'views' => $ad->views_count,
                        'clicks' => $ad->clicks_count,
                    ]
                ];
            })
        ]);
    }

    /**
     * API: Track a click on an advertisement.
     */
    public function trackClick(Advertisement $advertisement)
    {
        $advertisement->increment('clicks_count');
        return response()->json(['status' => 'success']);
    }

    /**
     * API: Track a view on an advertisement.
     */
    public function trackView(Advertisement $advertisement)
    {
        $advertisement->increment('views_count');
        return response()->json(['status' => 'success']);
    }
}
