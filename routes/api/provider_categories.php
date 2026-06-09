<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProviderCategoryRequestController;

Route::middleware('auth:sanctum')->group(function () {
    // Provider routes
    Route::post('/provider-category-requests', [ProviderCategoryRequestController::class, 'store']);
    
    // Admin routes
    Route::middleware('can:adminViewAny,App\Models\User')->group(function () {
        Route::get('/admin/provider-category-requests', [ProviderCategoryRequestController::class, 'index']);
        Route::patch('/admin/provider-category-requests/{id}/status', [ProviderCategoryRequestController::class, 'updateStatus']);
    });
});
