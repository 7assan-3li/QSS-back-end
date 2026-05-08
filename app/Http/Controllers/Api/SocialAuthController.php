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

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                ]);
            } else {
                // Combine updates into one array for efficiency
                $updateData = [];
                if (!$user->google_id) {
                    $updateData['google_id'] = $googleUser->id;
                }
                if (is_null($user->email_verified_at)) {
                    $updateData['email_verified_at'] = now();
                }
                if (!$user->avatar) {
                    $updateData['avatar'] = $googleUser->avatar;
                }

                if (!empty($updateData)) {
                    $user->update($updateData);
                }
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
