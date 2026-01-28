<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;


Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
    //bank routes
    Route::get('/banks',[BankController::class, 'getAllBanks']);
});
