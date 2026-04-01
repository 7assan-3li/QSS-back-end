<?php

namespace App\Services;
use App\Models\ProfilePhone;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class ProfilePhoneService
{
    public function index($user)
    {
        if (!$user->profile) {
            return [];
        }
        return ProfilePhone::where('profile_id', $user->profile->id)->get();
    }

    public function create($user, array $data)
    {
        if (!$user->profile) {
            abort(403, 'User does not have a profile.');
        }

        $data['profile_id'] = $user->profile->id;

        // Handle primary phone logic
        if (!empty($data['is_primary'])) {
            ProfilePhone::where('profile_id', $user->profile->id)->update(['is_primary' => false]);
        }

        return ProfilePhone::create($data);
    }

    public function update($user, array $data, $profile_phone_id)
    {
        if (!$user->profile) {
            abort(403, 'User does not have a profile.');
        }

        $profilePhone = ProfilePhone::where('id', $profile_phone_id)
            ->where('profile_id', $user->profile->id)
            ->firstOrFail();

        // Handle primary phone logic
        if (!empty($data['is_primary'])) {
            ProfilePhone::where('profile_id', $user->profile->id)->update(['is_primary' => false]);
        }

        $profilePhone->update($data);
        return $profilePhone->fresh();
    }

    public function delete($user, $profile_phone_id)
    {
        if (!$user->profile) {
            abort(403, 'User does not have a profile.');
        }

        $profilePhone = ProfilePhone::where('id', $profile_phone_id)
            ->where('profile_id', $user->profile->id)
            ->firstOrFail();

        $profilePhone->delete();
        return true;
    }
}