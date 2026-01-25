<?php

namespace App\Policies;

use App\constant\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === Role::ADMIN || $user->role === Role::EMPLOYEE;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Service $service): bool
    {
        return $user->id === $service->provider_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === Role::PROVIDER;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        return ($user->role === Role::PROVIDER && $user->id === $service->provider_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        return ($user->role === Role::PROVIDER && $user->id === $service->provider_id) ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        return false;
    }

    public function adminViewAny(User $user): bool
    {
        return $user->role === Role::ADMIN || $user->role === Role::EMPLOYEE;
    }

    public function adminUpdate(User $user, Service $service): bool
    {
        return  $user->role === Role::ADMIN;
    }
    public function adminDelete(User $user, Service $service): bool
    {
        return  $user->role === Role::ADMIN;
    }

}