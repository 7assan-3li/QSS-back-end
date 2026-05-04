<?php

namespace App\Policies;

use App\constant\Role;
use App\Models\BankSystemAccount;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BankSystemAccountPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN,Role::EMPLOYEE]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BankSystemAccount $account): bool
    {
        return in_array($user->role, [Role::ADMIN]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BankSystemAccount $account): bool
    {
        return in_array($user->role, [Role::ADMIN]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BankSystemAccount $account): bool
    {
        return in_array($user->role, [Role::ADMIN]);
    }
}
