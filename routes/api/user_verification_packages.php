<?php

use App\Http\Controllers\UserVerificationPackagesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {
    Route::get('/user-verification-packages', [UserVerificationPackagesController::class, 'index']);
    Route::post('/user-verification-packages', [UserVerificationPackagesController::class, 'store']);
    Route::get('/user-verification-packages/{id}', [UserVerificationPackagesController::class, 'show']);

    Route::middleware(['is_admin'])->group(function () {
        Route::get('/admin/user-verification-packages', [UserVerificationPackagesController::class, 'indexAdmin']);
        Route::post('/user-verification-packages/{id}/approve', [UserVerificationPackagesController::class, 'approve']);
        Route::post('/user-verification-packages/{id}/reject', [UserVerificationPackagesController::class, 'reject']);
    });
});
