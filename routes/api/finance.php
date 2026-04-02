<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\UserBankController;
use App\Http\Controllers\PointsController;
use Illuminate\Support\Facades\Route;

// Public Banks List
Route::get('banks', [BankController::class, 'getAllBanks']);

// Points Management
Route::middleware(['auth:sanctum', 'seeker.policy'])->group(function () {
    Route::post('points/convert', [PointsController::class, 'convertPaidToBonus']);
    Route::get('points/transactions', [PointsController::class, 'indexTransactions']);
    Route::get('points/balance', [PointsController::class, 'getPointsBalance']);
});

// User Bank Accounts
Route::middleware(['auth:sanctum', 'seeker.policy'])->controller(UserBankController::class)->prefix('user-banks')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{account_id}', 'show');
    Route::put('/{userBankId}', 'update');
});