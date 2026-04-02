<?php

use App\Http\Controllers\VerificationPackagesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {
    Route::get('/verification-packages', [VerificationPackagesController::class, 'index']);
    Route::get('/verification-packages/create', [VerificationPackagesController::class, 'create']);
    Route::post('/verification-packages', [VerificationPackagesController::class, 'store']);
    Route::get('/verification-packages/{id}', [VerificationPackagesController::class, 'show']);
    Route::put('/verification-packages/{id}', [VerificationPackagesController::class, 'update']);
    Route::delete('/verification-packages/{id}', [VerificationPackagesController::class, 'destroy']);
});
