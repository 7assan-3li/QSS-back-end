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
            // Use stateless() for APIs
            $googleUser = Socialite::driver('google')->stateless()->userFromToken($request->access_token);

            $user = User::updateOrCreate([
                'email' => $googleUser->email,
            ], [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'password' => Hash::make(Str::random(16)), // Random password for social login
                'email_verified_at' => now(), // Social users are verified
            ]);

            $token = $user->createToken('SocialToken')->plainTextToken;

            return response()->json([
                'message' => 'Logged in successfully',
                'user' => $user,
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
