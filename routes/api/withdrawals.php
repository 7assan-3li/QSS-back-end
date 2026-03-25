<?php

use App\Http\Controllers\WithdrawRequestController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/withdraw-request', [WithdrawRequestController::class, 'store']);
    Route::get('/my-withdraw-requests', [WithdrawRequestController::class, 'indexUser']);
});
