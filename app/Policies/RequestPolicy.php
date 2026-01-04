<?php

namespace App\Policies;

use App\constant\Role;
use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Request $request): bool
    {
        return false;
    }

    public function updateStatusAdmin(User $user, Request $request): bool
    {
        return $user->role === Role::EMPLOYEE || $user->role === Role::ADMIN;
    }

    public function updateStatusSeeker(User $user, Request $request): bool
    {
        return $user->id === $request->user->id || $user->role === Role::ADMIN ;
    }
    public function updateStatusProvider(User $user, Request $request): bool
    {
        return $user->id === $request->serviceProvider->id || $user->role === Role::ADMIN ;
    }
}
