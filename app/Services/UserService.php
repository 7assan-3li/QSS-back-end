<?php

namespace App\Services;

use App\Models\UserPointsPackage;
use App\Models\User;
use App\constant\BondStatus;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function update($userId, $data)
    {
        $user = User::findOrFail($userId);
        $user->update($data);
        return $user;
    }
}