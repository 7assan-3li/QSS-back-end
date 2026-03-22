<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProviderRequestController;
use App\Http\Controllers\RequestCommissionBondController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SystemComplaintController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationPackagesController;
use App\Http\Controllers\VerificationRequestController;
use App\Models\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return response()->view('auth.email-verified');
})->middleware(['signed'])->name('verification.verify');

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'loginPage'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.store')->middleware('throttle:6,1');
});


Route::middleware(['auth', 'is_admin'])->group(function () {
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

    //service request routes
    Route::get('/requests', [RequestController::class, 'indexAdmin'])->name('requests.index');
    Route::get('/requests/{request}', [RequestController::class, 'showAdmin'])->name('requests.show');
    Route::patch('/requests/{request}/status', [RequestController::class, 'updateStatusAdmin'])->name('requests.update.status');
    Route::post('/requests', [RequestController::class, 'storeAdmin'])->name('requests.store');
    Route::patch('/requests/{request}/mark-paid', [RequestController::class, 'markPaid'])
        ->name('requests.markPaid');

    //request commission bonds
    Route::patch('/request-commission-bonds/{bond}/approve', [RequestCommissionBondController::class, 'approve'])
        ->name('commission-bonds.approve');

    Route::patch('/request-commission-bonds/{bond}/reject', [RequestCommissionBondController::class, 'reject'])
        ->name('commission-bonds.reject');

    //verification request routes
    Route::get('/verification-requests', [VerificationRequestController::class, 'indexAdmin'])->name('verification-requests.index');
    Route::get('/verification-requests/{verificationRequest}', [VerificationRequestController::class, 'showAdmin'])->name('verification-requests.show');
    Route::patch('/verification-requests/{verificationRequest}/status', [VerificationRequestController::class, 'updateStatusAdmin'])->name('verification-requests.update.status');
    Route::post('/verification-requests/{id}/accept', [VerificationRequestController::class, 'acceptAdmin'])->name('verification-requests.accept');
    Route::post('/verification-requests/{id}/reject', [VerificationRequestController::class, 'rejectAdmin'])->name('verification-requests.reject');

    //verification packages routes
    Route::get('/verification-packages', [VerificationPackagesController::class, 'indexAdmin'])->name('verification-packages.index');
    Route::get('/verification-packages/create', [VerificationPackagesController::class, 'create'])->name('verification-packages.create');
    Route::post('/verification-packages', [VerificationPackagesController::class, 'store'])->name('verification-packages.store');
    Route::get('/verification-packages/{verificationPackage}', [VerificationPackagesController::class, 'showAdmin'])->name('verification-packages.show');
    Route::get('/verification-packages/{verificationPackage}/edit', [VerificationPackagesController::class, 'edit'])->name('verification-packages.edit');
    Route::put('/verification-packages/{verificationPackage}', [VerificationPackagesController::class, 'update'])->name('verification-packages.update');
    Route::delete('/verification-packages/{verificationPackage}', [VerificationPackagesController::class, 'destroy'])->name('verification-packages.destroy');
    //user verification packages routes
    Route::get('/user-verification-packages', [\App\Http\Controllers\UserVerificationPackagesController::class, 'indexWebAdmin'])->name('user-verification-packages.index');
    Route::get('/user-verification-packages/{id}', [\App\Http\Controllers\UserVerificationPackagesController::class, 'showWebAdmin'])->name('user-verification-packages.show');
    Route::patch('/user-verification-packages/{id}/approve', [\App\Http\Controllers\UserVerificationPackagesController::class, 'approveWebAdmin'])->name('user-verification-packages.approve');
    Route::patch('/user-verification-packages/{id}/reject', [\App\Http\Controllers\UserVerificationPackagesController::class, 'rejectWebAdmin'])->name('user-verification-packages.reject');
});

Route::get('/system-complaints', [SystemComplaintController::class, 'indexAdmin'])->name('system-complaints.index');
Route::get('/system-complaints/{systemComplaint}', [SystemComplaintController::class, 'showAdmin'])
    ->name('system-complaints.show');

Route::patch('/system-complaints/{systemComplaint}/status', [SystemComplaintController::class, 'updateStatus'])
    ->name('system-complaints.update-status');
