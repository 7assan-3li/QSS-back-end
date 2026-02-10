<?php

use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
   //review routes
   Route::post('/reviews', [ReviewController::class, 'store']);
   Route::post('/reviews/{id}', [ReviewController::class,'update']);
});