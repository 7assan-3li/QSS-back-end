<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreviousWorkController;

Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {
    //previous work routes
    Route::get('/previous-work', [PreviousWorkController::class, 'index']);
    Route::post('/previous-work', [PreviousWorkController::class, 'store']);
    Route::get('/previous-work/{previousWork_id}', [PreviousWorkController::class, 'show']);
    Route::put('/previous-work/{previousWork_id}', [PreviousWorkController::class, 'update']);
    Route::delete('/previous-work/{previousWork_id}', [PreviousWorkController::class, 'destroy']);
});
