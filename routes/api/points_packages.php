<?php

use App\Http\Controllers\PointsPackageController;
use App\Http\Controllers\UserPointsPackageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {
    
    // User Routes
    Route::get('/available-points-packages', [UserPointsPackageController::class, 'availablePackages']);
    Route::get('/available-points-packages/{id}', [UserPointsPackageController::class, 'show']);
    Route::get('/my-points-packages', [UserPointsPackageController::class, 'myPackages']);
    Route::post('/subscribe-points-package', [UserPointsPackageController::class, 'subscribe']);

    // Admin Routes
    Route::middleware('is_admin')->group(function () {
        // Manage Packages
        Route::apiResource('points-packages', PointsPackageController::class);
        Route::patch('points-packages/{id}/toggle-status', [PointsPackageController::class, 'toggleStatus']);

        // Manage Subscriptions
        Route::get('user-points-packages', [UserPointsPackageController::class, 'index']);
        Route::post('user-points-packages/{id}/approve', [UserPointsPackageController::class, 'approve']);
        Route::post('user-points-packages/{id}/reject', [UserPointsPackageController::class, 'reject']);
    });
});
