<?php

use App\Http\Controllers\FavoriteServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites', [FavoriteServiceController::class, 'index']);
    Route::post('/favorites/toggle', [FavoriteServiceController::class, 'toggle']);
});
