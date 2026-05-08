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
                    'password' => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                ]);
            } else {
                // Update Google ID if not already set
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                if(!$user->email_verified_at){
                    $user->update(['email_verified_at' => now()]);
                }
            }

            // Use updateOrCreate for profile to avoid duplicate key errors
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
