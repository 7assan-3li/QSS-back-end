<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DeviceTokensController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    
    // Device Tokens Routes
    Route::post('/store-token', [DeviceTokensController::class, 'store']);
    Route::post('/remove-token', [DeviceTokensController::class, 'destroy']);
});

