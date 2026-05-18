<?php

use App\Http\Controllers\Api\ProviderDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified','provider.policy','check_unpaid_commissions'])->group(function () {
    Route::get('/provider/dashboard', [ProviderDashboardController::class, 'index']);
});
