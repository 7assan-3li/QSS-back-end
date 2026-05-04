<?php

namespace App\Policies;

use App\Models\User;

class FinancialPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $user->role === \App\constant\Role::EMPLOYEE;
    }
}
