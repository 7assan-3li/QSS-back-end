<?php

namespace App\Policies;

use App\constant\RequestStatus;
use App\constant\Role;
use App\Models\RequestCommissionBond;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequestCommissionBondPolicy
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
    public function view(User $user, RequestCommissionBond $requestCommissionBond): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RequestCommissionBond $requestCommissionBond): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RequestCommissionBond $requestCommissionBond): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RequestCommissionBond $requestCommissionBond): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RequestCommissionBond $requestCommissionBond): bool
    {
        return false;
    }

    
}
