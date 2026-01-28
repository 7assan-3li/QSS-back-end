<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestCommissionBondController;


Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
    //request commission bonds routes
    Route::get('/request-commission-bonds', [RequestCommissionBondController::class, 'index']);
    Route::post('/request-commission-bonds', [RequestCommissionBondController::class, 'store']);
});
