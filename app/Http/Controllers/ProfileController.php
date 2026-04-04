<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Models\User;
use App\Services\ProfileService;
use App\Http\Resources\ProfileResource;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function show($profile_id)
    {
        $profile = Profile::with(['user.banks', 'profilePhones', 'previousWorks'])->findOrFail($profile_id);
        return response()->json([
            'message' => 'Profile retrieved successfully',
            'profile' => new ProfileResource($profile)
        ], 200);
    }
    public function showUserProfile($user_id)
    {
        $user = User::findOrFail($user_id);
        $profile = $user->profile;
        $profile->load(['user.banks', 'profilePhones', 'previousWorks']);
        return response()->json([
            'message' => 'Profile retrieved successfully',
            'profile' => new ProfileResource($profile)
        ], 200);
    }
    public function showMyProfile()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $profile->load(['user.banks', 'profilePhones', 'previousWorks']);
        return response()->json([
            'message' => 'Profile retrieved successfully',
            'profile' => new ProfileResource($profile)
        ], 200);
    }

    public function store(StoreProfileRequest $request, ProfileService $profileService)
    {

        $validated = $request->validated();
        $profile = $profileService->create($validated, $request);

        return response()->json([
            'message' => 'Profile created successfully',
            'profile' => new ProfileResource($profile)
        ], 201);

    }

    public function update(UpdateProfileRequest $request, ProfileService $profileService)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $profile_id = $user->profile->id;
        $user = $this->userService->update($user->id, $validated);
        $profile = $profileService->update($validated, $request, $profile_id);
        $profile['name'] = $user->name;
        $profile['email'] = $user->email;
        $profile['phone'] = $user->phone;

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => new ProfileResource($profile)
        ], 200);
    }
}