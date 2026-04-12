<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestBondController;


Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {
    Route::get('/request-bonds', [RequestBondController::class, 'index']);
    Route::post('/request-bonds', [RequestBondController::class, 'store']);

    Route::middleware('provider.policy')->group(function () {
        // Provider endpoints
        Route::get('/provider-request-bonds', [RequestBondController::class, 'providerIndex']);
        Route::patch('/request-bonds/{bond}/approve', [RequestBondController::class, 'approve']);
        Route::patch('/request-bonds/{bond}/reject', [RequestBondController::class, 'reject']);
    });
});
