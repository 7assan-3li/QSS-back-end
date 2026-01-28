<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestComplaintController;


Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
    //requestComplaint routes
    Route::post('/request-complaints',[RequestComplaintController::class, 'store']);
});
