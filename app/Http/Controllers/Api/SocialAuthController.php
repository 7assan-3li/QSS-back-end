<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Handle Google login via token (for Mobile/Frontend).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleCallback(Request $request)
    {
        $request->validate([
            'access_token' => 'required',
        ]);

        try {
            $googleUser = Socialite::driver('google')->stateless()->userFromToken($request->access_token);

            // 1. البحث عن طريق المعرف الخاص بجوجل أولاً (الطريقة الأدق)
            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                // 2. إذا لم يكن مسجلاً بالمعرف، نبحث عن طريق الإيميل (لربط الحسابين)
                $user = User::where('email', $googleUser->email)->first();

                if ($user) {
                    // ربط حساب جوجل بالحساب الحالي
                    $user->update(['google_id' => $googleUser->id]);
                } else {
                    // 3. إذا لم يكن الإيميل موجوداً، نقوم بإنشاء حساب جديد كلياً
                    $user = User::create([
                        'email' => $googleUser->email,
                        'name' => $googleUser->name,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                        'password' => Hash::make(Str::random(16)),
                        'email_verified_at' => now(),
                    ]);
                }
            }

            // تحديث بيانات المستخدم (في حال كان موجوداً وناقصاً للتوثيق أو الصورة)
            $updateData = [];
            if (is_null($user->email_verified_at)) {
                $updateData['email_verified_at'] = now();
            }
            // تحديث الصورة فقط إذا لم يكن لديه صورة سابقة
            if (!$user->avatar && $googleUser->avatar) {
                $updateData['avatar'] = $googleUser->avatar;
            }

            if (!empty($updateData)) {
                $user->update($updateData);
            }

            // Use updateOrCreate for profile to ensure image_path is updated
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['image_path' => $googleUser->avatar]
            );

            $token = $user->createToken('SocialToken')->plainTextToken;

            return response()->json([
                'message' => 'Logged in successfully',
                'user' => $user->load('profile'), // Include profile in response
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid credentials or error occurred: ' . $e->getMessage(),
            ], 401);
        }
    }
}
