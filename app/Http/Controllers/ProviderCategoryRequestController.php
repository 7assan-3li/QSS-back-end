<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreProviderCategoryRequest;
use App\Models\ProviderCategoryRequest;
use App\Models\ProviderCategory;
use Illuminate\Support\Facades\Auth;
use App\constant\ProviderRequestStatus;

class ProviderCategoryRequestController extends Controller
{
    /**
     * Provider submits a new category request.
     */
    public function store(StoreProviderCategoryRequest $request)
    {
        $validated = $request->validated();
        $user_id = Auth::id();

        // Check if provider already has this category
        $alreadyHasCategory = ProviderCategory::where('user_id', $user_id)
            ->where('category_id', $validated['category_id'])
            ->exists();

        if ($alreadyHasCategory) {
            return response()->json(['message' => 'أنت تملك تصريحاً لهذا القسم بالفعل.'], 422);
        }

        // Check if a pending request already exists
        $pendingRequest = ProviderCategoryRequest::where('user_id', $user_id)
            ->where('category_id', $validated['category_id'])
            ->where('status', ProviderRequestStatus::PENDING)
            ->exists();

        if ($pendingRequest) {
            return response()->json(['message' => 'لديك طلب قيد المراجعة لهذا القسم بالفعل.'], 422);
        }

        $documentPath = $request->file('document')->store('provider_categories_documents', 'public');

        $categoryRequest = ProviderCategoryRequest::create([
            'user_id' => $user_id,
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'document_path' => $documentPath,
            'status' => ProviderRequestStatus::PENDING,
        ]);

        return response()->json([
            'message' => 'تم تقديم طلب إضافة القسم بنجاح وهو قيد المراجعة.',
            'request' => $categoryRequest
        ], 201);
    }

    /**
     * Admin lists all category requests.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = ProviderCategoryRequest::with(['user', 'category']);

        if ($status) {
            $query->where('status', $status);
        }

        return response()->json($query->latest()->get());
    }

    /**
     * Admin approves or rejects the request.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:' . ProviderRequestStatus::ACCEPTED . ',' . ProviderRequestStatus::REJECTED,
            'rejection_reason' => 'required_if:status,' . ProviderRequestStatus::REJECTED . '|string|nullable',
            'max_services' => 'required_if:status,' . ProviderRequestStatus::ACCEPTED . '|integer|min:1',
        ]);

        $categoryRequest = ProviderCategoryRequest::findOrFail($id);

        if ($categoryRequest->status !== ProviderRequestStatus::PENDING) {
            return response()->json(['message' => 'لا يمكن تغيير حالة الطلب لأنه ليس قيد الانتظار.'], 422);
        }

        $categoryRequest->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['status'] === ProviderRequestStatus::REJECTED ? $validated['rejection_reason'] : null,
            'admin_id' => Auth::id(),
        ]);

        if ($validated['status'] === ProviderRequestStatus::ACCEPTED) {
            ProviderCategory::firstOrCreate([
                'user_id' => $categoryRequest->user_id,
                'category_id' => $categoryRequest->category_id,
            ], [
                'max_services' => $validated['max_services'] ?? 5,
                'is_active' => true,
            ]);

            // Notify user
            // $notificationService->sendToUser(...)
        }

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح.',
            'request' => $categoryRequest
        ]);
    }
}
