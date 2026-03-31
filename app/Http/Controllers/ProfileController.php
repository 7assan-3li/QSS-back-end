<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Services\ProfileService;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{

    public function show($profile_id)
    {
        $profile = Profile::with(['user.banks', 'profilePhones', 'previousWorks'])->findOrFail($profile_id);
        return response()->json([
            'message' => 'Profile retrieved successfully',
            'profile' => new ProfileResource($profile)
        ], 200);
    }

    public function store(StoreProfileRequest $request,ProfileService $profileService)
    {

        $validated = $request->validated();
        $profile = $profileService->create($validated, $request );

        return response()->json([
            'message' => 'Profile created successfully',
            'profile' => new ProfileResource($profile)
        ], 201);

    }
 
    public function update(UpdateProfileRequest $request,ProfileService $profileService,$profile_id)
    {
        $validated = $request->validated();

        $profile = $profileService->update($validated, $request, $profile_id);

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => new ProfileResource($profile)
        ], 200);
    }
}