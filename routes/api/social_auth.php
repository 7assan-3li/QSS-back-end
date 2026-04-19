<?php

use App\Http\Controllers\Api\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
