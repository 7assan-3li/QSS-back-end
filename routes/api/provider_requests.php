<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProviderRequestController;


Route::middleware(['auth:sanctum', 'verified','seeker.policy', 'check_unpaid_commissions'])->group(function () {
    //provider request routes
    Route::get('/provider-requests', [ProviderRequestController::class, 'index']);
    Route::post('/provider-requests', [ProviderRequestController::class, 'store']);
    Route::post('/provider-requests/{providerRequest}/status', [ProviderRequestController::class, 'updateStatus']);
});
