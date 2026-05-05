<?php

namespace App\Policies;

use App\constant\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
    public function view(User $user, User $model): bool
    {
        if ($user->role === Role::ADMIN) {
            return true;
        }

        if ($user->role === Role::EMPLOYEE) {
            return in_array($model->role, [Role::SEEKER, Role::PROVIDER]);
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Only Admin can update account data
        return $user->role === Role::ADMIN && $model->role !== Role::ADMIN;
    }

    public function suspend(User $user, User $model): bool
    {
        // Admin can suspend anyone except other Admins
        if ($user->role === Role::ADMIN) {
            return $model->role !== Role::ADMIN;
        }

        // Employee can suspend Seekers and Providers only
        if ($user->role === Role::EMPLOYEE) {
            return in_array($model->role, [Role::SEEKER, Role::PROVIDER]);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Only Admin can delete accounts
        return ($user->role === Role::ADMIN) && $model->role !== Role::ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    public function viewDashboard(User $user): bool
    {
        return $user->role === Role::ADMIN || $user->role === Role::EMPLOYEE;
    }

    

}
