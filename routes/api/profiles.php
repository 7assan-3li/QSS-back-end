<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
    //bank routes
    Route::post('/profiles',[ProfileController::class, 'store']);
    Route::get('/profiles/{id}',[ProfileController::class, 'show']);
    Route::put('/profiles/{id}',[ProfileController::class, 'update']);
});