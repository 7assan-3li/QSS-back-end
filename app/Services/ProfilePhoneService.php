<?php

namespace App\Services;
use App\Models\ProfilePhone;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class ProfilePhoneService
{
    public function create(array $data)
    {
        $profilePhone = ProfilePhone::create($data);
        return $profilePhone;
    }
    public function update($data, $profile_phone_id){
        $profilePhone = ProfilePhone::find($profile_phone_id);
        $profilePhone->update($data);
        return $profilePhone;
    }
}