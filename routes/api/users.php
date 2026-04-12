<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', fn(Request $request) => $request->user())->middleware('auth:sanctum');
Route::patch('/change-password', [UserController::class, 'apiUpdatePassword'])->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index']);
