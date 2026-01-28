<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

//unprotected routes
Route::get('/categories',[CategoryController::class, 'displayMain']);
Route::get('/categories/{category}',[CategoryController::class, 'showCategory']);
