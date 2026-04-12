<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\UserBankController;
use App\Http\Controllers\PointsController;
use Illuminate\Support\Facades\Route;

// Public Banks List
Route::get('banks', [BankController::class, 'getAllBanks']);

// Points Management
Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
    Route::get('points/transactions', [PointsController::class, 'indexTransactions']);
    Route::get('points/balance', [PointsController::class, 'getPointsBalance']);
    Route::middleware('provider.policy')->group(function () {
        Route::post('points/convert', [PointsController::class, 'convertPaidToBonus']);
    });
});

// User Bank Accounts
Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->controller(UserBankController::class)->prefix('user-banks')->group(function () {
   
    Route::get('/{account_id}', 'show');
    Route::put('/{userBankId}', 'update');
});