<?php

use App\Http\Controllers\VerificationRequestController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {
    //VerificationRequest routes
    Route::get('/verification-requests', [VerificationRequestController::class, 'index']);
    Route::post('/verification-requests', [VerificationRequestController::class, 'store']);
    Route::get('/verification-requests/{id}', [VerificationRequestController::class, 'show']);

});