<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

//request routes

Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {

    Route::get('/requests', [RequestController::class, 'index']);
    Route::post('/requests', [RequestController::class, 'store']);
    Route::get('/requests/meeting-provider', [App\Http\Controllers\RequestMeetingServiceController::class, 'indexProvider']);   
    Route::get('/requests/meeting-seeker', [App\Http\Controllers\RequestMeetingServiceController::class, 'indexSeeker']);   
    Route::post('/requests/meeting', [App\Http\Controllers\RequestMeetingServiceController::class, 'store']);
    Route::get('/requests/custom-provider', [App\Http\Controllers\RequestCustomServiceController::class, 'indexProvider']);
    Route::get('/requests/custom-seeker', [App\Http\Controllers\RequestCustomServiceController::class, 'indexSeeker']);
    Route::post('/requests/custom', [App\Http\Controllers\RequestCustomServiceController::class, 'store']);
    Route::patch('/requests/custom/{request}/price', [App\Http\Controllers\RequestCustomServiceController::class, 'setPrice']);
    Route::get('/requests/{request}', [RequestController::class, 'show']);
    Route::get('/requests/{request}/status', [RequestController::class, 'getRequestStatus']);
    Route::patch('/requests/{request}/status', [RequestController::class, 'updateStatus']);
});
