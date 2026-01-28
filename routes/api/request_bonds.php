<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestBondController;


Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
    //request bonds routes
    Route::get('/request-bonds', [RequestBondController::class, 'index']);
    Route::post('/request-bonds', [RequestBondController::class, 'store']);
});
