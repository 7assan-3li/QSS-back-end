<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProviderRequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'loginPage'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.store');
});


Route::middleware(['auth','is_admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    //user Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.update.password');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify.email');


    // Category Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    //service Routes
    Route::get('/services', [ServiceController::class, 'adminIndex'])->name('services.index');
    Route::get('/services/{service}', [ServiceController::class, 'AdminShow'])->name('services.show');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    //provider request routes
    Route::get('/provider-requests', [ProviderRequestController::class, 'adminIndex'])->name('provider-requests.index');
    Route::post('/provider-requests', [ProviderRequestController::class, 'store'])->name('provider-requests.store');
    Route::get('/provider-requests/{providerRequest}', [ProviderRequestController::class, 'adminShow'])->name('provider-requests.show');
    Route::patch('/provider-requests/{providerRequest}/status', [ProviderRequestController::class, 'updateStatus'])->name('provider-requests.update.status');

    //bank routes
    Route::get('/banks', [BankController::class, 'index'])->name('banks.index');
    Route::get('banks/create', [BankController::class, 'create'])->name('banks.create');
    Route::post('/banks', [BankController::class, 'store'])->name('banks.store');
    Route::get('/banks/{bank}', [BankController::class, 'show'])->name('banks.show');
    Route::get('/banks/{bank}/edit', [BankController::class, 'edit'])->name('banks.edit');
    Route::put('/banks/{bank}', [BankController::class, 'update'])->name('banks.update');
    Route::delete('/banks/{bank}', [BankController::class, 'destroy'])->name('banks.destroy');
});
