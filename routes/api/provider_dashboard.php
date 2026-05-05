<?php

use App\Http\Controllers\Api\ProviderDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/provider/dashboard', [ProviderDashboardController::class, 'index']);
});
