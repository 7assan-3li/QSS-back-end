<?php

use App\Http\Controllers\ProviderRequestController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'provider.policy'])->controller(ProviderRequestController::class)->prefix('provider-requests')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{providerRequest}', 'show');
    Route::delete('/{providerRequest}', 'destroy');
});