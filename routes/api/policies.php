<?php

use Illuminate\Support\Facades\Route;


Route::get('/policies/seeker', [App\Http\Controllers\PolicyController::class, 'getSeekerPolicy']);
Route::get('/policies/provider', [App\Http\Controllers\PolicyController::class, 'getProviderPolicy']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::patch('/policies/seeker', [App\Http\Controllers\PolicyController::class, 'acceptSeekerPolicy']);
    Route::patch('/policies/provider', [App\Http\Controllers\PolicyController::class, 'acceptProviderPolicy']);
});
