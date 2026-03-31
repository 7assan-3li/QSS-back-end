<?php

use App\Http\Controllers\MeetingAndCustomServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ScheduleServiceController;
use Illuminate\Support\Facades\Route;

//service routes
Route::get('/all-services', [ServiceController::class, 'showAll']);
Route::middleware(['auth:sanctum', 'verified', 'seeker.policy'])->group(function () {
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::get('/services/{service}', [ServiceController::class, 'show']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);
    
    // Schedule Routes
    Route::get('/services/{serviceId}/schedules', [ScheduleServiceController::class, 'index']);
    Route::post('/services/schedules', [ScheduleServiceController::class, 'store']);
    Route::put('/services/schedules/{id}', [ScheduleServiceController::class, 'update']);
    Route::delete('/services/schedules/{id}', [ScheduleServiceController::class, 'destroy']);

    Route::post('/services/children', [ServiceController::class, 'storeChild']);
    Route::put('/services/children/{childService}', [ServiceController::class, 'updateChild']);
    Route::delete('/services/children/{childService}', [ServiceController::class, 'deleteChild']);
    Route::put('/services/type/{type}', [ServiceController::class, 'updateByType']);

    Route::put('/services-meeting', [MeetingAndCustomServiceController::class, 'updateMeetingService']);
    Route::put('/services-custom', [MeetingAndCustomServiceController::class, 'updateCustomService']);
});
