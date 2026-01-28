<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Resend Verification Email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return response()->json([
        'message' => 'Verification link sent'
    ]);
})->middleware(['auth:sanctum', 'throttle:6,1']);



Route::post('/logout', [UserController::class, 'apiLogout'])->middleware('auth:sanctum');
