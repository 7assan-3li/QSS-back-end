<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserBankController;


Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
    //user bank account routes
    Route::get('/user-bank',[UserBankController::class, 'index']);
    Route::post('/user-bank',[UserBankController::class, 'store']);
    Route::get('/user-bank/{userBank}',[UserBankController::class,'show']);
    Route::put('/user-bank/{userBank}', [UserBankController::class, 'update']);
});
