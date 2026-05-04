<?php

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\User;
use App\constant\Role;
use Illuminate\Auth\Access\Response;

class AdvertisementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === Role::EMPLOYEE || $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Advertisement $advertisement): bool
    {
        return $user->role === Role::EMPLOYEE || $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === Role::EMPLOYEE || $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Advertisement $advertisement): bool
    {
        return $user->role === Role::EMPLOYEE || $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Advertisement $advertisement): bool
    {
        return $user->role === Role::EMPLOYEE || $user->role === Role::ADMIN;
    }
}
