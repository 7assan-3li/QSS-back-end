<?php

namespace App\Http\Controllers;

use App\constant\RequestStatus;
use App\Models\Request as ModelsRequest;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {

        $validated = $request->validate([
            'request_id' => 'required|exists:requests,id',
            'rating'     => 'required|numeric|min:1|max:5',
            'comment'    => 'nullable|string|max:2000',
        ]);

        $requestModel = ModelsRequest::findOrFail($request->request_id);

        if ($requestModel->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'ليس لديك الصلاحية لتقييم والتعليق على هذا الطلب'
            ], 422);
        }

        if ($requestModel->status !== RequestStatus::COMPLETED) {
            return response()->json([
                'message' => 'الطلب لم يكتمل بعد!'
            ], 422);
        }

        // منع تكرار التقييم
        $exists = Review::where('request_id', $validated['request_id'])->exists();

        if ($exists) {
            return response()->json([
                'message' => 'تم تقييم هذا الطلب مسبقًا'
            ], 422);
        }

        $review = Review::create($validated);

        $mainService = $requestModel->main_service->first();

        $averageRating = $mainService->requests()
            ->whereHas('review')
            ->join('reviews', 'reviews.request_id', '=', 'requests.id')
            ->selectRaw('AVG(reviews.rating) as avg_rating')
            ->value('avg_rating');

        $mainService->update([
            'rating_avg' => round($averageRating ?? 0, 2),
        ]);

        $user = $mainService->provider;
        $userRating =  $user->mainServices()
            ->whereNotNull('rating_avg')
            ->avg('rating_avg');
        $user->update([
            'rating_avg' => round($userRating, 2),
        ]);



        return response()->json([
            'message' => 'تم إضافة التقييم بنجاح',
            'review'  => $review,
        ], 201);
    }

    // hidden or display review
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $request->validate([
            'is_hidden' => 'required|boolean',
        ]);
        $review->update([
            'is_hidden' => $request->is_hidden,
        ]);
        return response()->json([
            'message' => 'تم تحديث التقييم بنجاح',
            'review'  => $review,
        ], 200);
    }
}
