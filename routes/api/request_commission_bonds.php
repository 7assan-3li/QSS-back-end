<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestCommissionBondController;


Route::middleware(['auth:sanctum', 'verified', 'provider.policy'])->group(function () {
    //request commission bonds routes
    Route::get('/request-commission-bonds', [RequestCommissionBondController::class, 'index']);
    Route::post('/request-commission-bonds', [RequestCommissionBondController::class, 'store']);
    Route::get('/provider-commission-summary', [RequestCommissionBondController::class, 'commissionSummary']);
});
