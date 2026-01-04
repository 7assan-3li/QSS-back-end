<?php

namespace App\Policies;

use App\constant\providerRequestStatus;
use App\constant\Role;
use App\Models\ProviderRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProviderRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->id === Auth::id() || $user->role === Role::ADMIN || $user->role === Role::EMPLOYEE;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProviderRequest $providerRequest): bool
    {
        return $user->id === $providerRequest->user_id || $user->role === Role::ADMIN || $user->role === Role::EMPLOYEE;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === Role::SEEKER;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProviderRequest $providerRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProviderRequest $providerRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProviderRequest $providerRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProviderRequest $providerRequest): bool
    {
        return false;
    }

    //admin functions
    public function adminViewAny(User $user): bool{
        return $user->role === Role::ADMIN || $user->role === Role::EMPLOYEE;
    }

    public function updateStatus(User $user, ProviderRequest $providerRequest): bool{
        return $user->role === Role::ADMIN || $user->role === Role::EMPLOYEE || $providerRequest->status === providerRequestStatus::PENDING;
    }
}