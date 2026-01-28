<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

//request routes

Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {

Route::get('/requests', [RequestController::class, 'index']);
Route::post('/requests', [RequestController::class, 'store']);
Route::get('/requests/{request}', [RequestController::class, 'show']);
Route::get('/requests/{request}/status', [RequestController::class, 'getRequestStatus']);
Route::patch('/requests/{request}/status', [RequestController::class, 'updateStatus']);
});
