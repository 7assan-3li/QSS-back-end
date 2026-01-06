<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\ProviderRequestController;
use App\Http\Controllers\RequestBondController;
use App\Http\Controllers\RequestComplaintController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register', [UserController::class, 'apiRegister']);
Route::post('/login', [UserController::class, 'apiLogin']);

// Email Verification Routes
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    // تحقق من صحة الرابط (hash)
    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->json([
            'message' => 'الرابط غير صالح'
        ], 403);
    }

    // تحقق إن كان المستخدم موثق بالفعل
    if ($user->hasVerifiedEmail()) {
        return response()->json([
            'message' => 'تم توثيق البريد مسبقاً'
        ]);
    }

    $user->markEmailAsVerified();

    return response()->json([
        'message' => 'تم توثيق البريد بنجاح'
    ]);
})->middleware('signed')->name('verification.verify');
// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return response()->json([
//         'message' => 'Email verified successfully'
//     ]);
// })->middleware([ 'signed'])
//     ->name('verification.verify');
// Resend Verification Email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return response()->json([
        'message' => 'Verification link sent'
    ]);
})->middleware(['auth:sanctum', 'throttle:6,1']);



Route::post('/logout', [UserController::class, 'apiLogout'])->middleware('auth:sanctum');


// Protected routes
Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {

    Route::get('/profile', fn(Request $request) => $request->user());

    Route::get('/users', [UserController::class, 'index']);

    //service routes
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::get('/services/{service}', [ServiceController::class, 'show']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);
    Route::post('/services/children', [ServiceController::class, 'storeChild']);

    //request routes
    Route::get('/requests', [RequestController::class, 'index']);
    Route::post('/requests', [RequestController::class, 'store']);
    Route::get('/requests/{request}', [RequestController::class, 'show']);
    Route::get('/requests/{request}/status', [RequestController::class, 'getRequestStatus']);
    Route::patch('/requests/{request}/status', [RequestController::class, 'updateStatus']);


    //request bonds routes
    Route::get('/request-bonds', [RequestBondController::class, 'index']);
    Route::post('/request-bonds', [RequestBondController::class, 'store']);

    //provider request routes
    Route::get('/provider-requests', [ProviderRequestController::class, 'index']);
    Route::post('/provider-requests', [ProviderRequestController::class, 'store']);
    Route::patch('/provider-requests/{providerRequest}/status', [ProviderRequestController::class, 'updateStatus']);

    //requestComplaint routes
    Route::post('/request-complaints',[RequestComplaintController::class, 'store']);

    
});