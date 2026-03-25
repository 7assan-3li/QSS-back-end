<?php

use App\Http\Controllers\ProfilePhoneController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
    //bank routes
    Route::get('/profile-phones', [ProfilePhoneController::class,'index']);
    Route::post('/profile-phones',[ProfilePhoneController::class, 'store']);
    Route::get('/profile-phones/{id}',[ProfilePhoneController::class, 'show']);
    Route::put('/profile-phones/{id}',[ProfilePhoneController::class, 'update']);
    Route::delete('/profile-phones/{id}',[ProfilePhoneController::class, 'destroy']);
});