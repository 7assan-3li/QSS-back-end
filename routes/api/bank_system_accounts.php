<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankSystemAccountController;

Route::middleware(['auth:sanctum', 'verified',])->group(function () {
    Route::get('/platform-bank-accounts', [BankSystemAccountController::class, 'getPlatformAccounts']);
});
