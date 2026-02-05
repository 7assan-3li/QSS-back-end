<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Services\ProfileService;

class ProfileController extends Controller
{

    public function show($profile_id)
    {
        $profile = Profile::with(['user','user.banks','profilePhones',])->findOrFail($profile_id);
        return response()->json([
            'message' => 'Profile retrieved successfully',
            'profile' => $profile
        ], 200);
    }

    public function store(StoreProfileRequest $request,ProfileService $profileService)
    {

        $validated = $request->validated();
        $profile = $profileService->create($validated, $request );

        return response()->json([
            'message' => 'Profile created successfully',
            'profile' => $profile
        ], 201);

    }
 
    public function update(UpdateProfileRequest $request,ProfileService $profileService,$profile_id)
    {
        $validated = $request->validated();

        $profile = $profileService->update($validated, $request, $profile_id);

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $profile
        ], 200);
    }
}