<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

// Request routes

// 1. Seeker Specific Operations (Requires Seeker Policy Acceptance)
Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {

        Route::get('/requests/seeker', [RequestController::class, 'indexSeeker']);
        Route::post('/requests', [RequestController::class, 'store']);
        Route::get('/requests/meeting-seeker', [App\Http\Controllers\RequestMeetingServiceController::class, 'indexSeeker']);
        Route::post('/requests/meeting', [App\Http\Controllers\RequestMeetingServiceController::class, 'store']);
        Route::get('/requests/custom-seeker', [App\Http\Controllers\RequestCustomServiceController::class, 'indexSeeker']);
        Route::post('/requests/custom', [App\Http\Controllers\RequestCustomServiceController::class, 'store']);
        Route::post('/requests/{request}/payByPoints', [RequestController::class, 'payByPoints']);

    // 2. Provider Specific Operations (Requires Provider Policy Acceptance)
    Route::middleware('provider.policy')->group(function () {
        Route::get('/requests/provider', [RequestController::class, 'indexProvider']);
        Route::get('/requests/meeting-provider', [App\Http\Controllers\RequestMeetingServiceController::class, 'indexProvider']);
        Route::get('/requests/custom-provider', [App\Http\Controllers\RequestCustomServiceController::class, 'indexProvider']);
        Route::patch('/requests/custom/{request}/price', [App\Http\Controllers\RequestCustomServiceController::class, 'setPrice']);
        Route::patch('/requests/custom/{request}/reject', [App\Http\Controllers\RequestCustomServiceController::class, 'reject']);
        Route::post('/requests/{request}/pay-commission', [RequestController::class, 'payCommissionByPoints']);
        Route::post('/requests/{request}/addAmountToMoneyPaid', [RequestController::class, 'addAmountToMoneyPaid']);
    });

    // 3. Shared Identity & Status Monitoring
    Route::get('/requests', [RequestController::class, 'index']); // Admin/General Oversight
    Route::get('/requests/{request}', [RequestController::class, 'show']);
    Route::get('/requests/{request}/status', [RequestController::class, 'getRequestStatus']);
    Route::patch('/requests/{request}/status', [RequestController::class, 'updateStatus']);
});
