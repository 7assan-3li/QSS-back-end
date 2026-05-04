<?php

namespace App\Policies;

use App\constant\Role;
use App\Models\User;
use App\Models\UserVerificationPackages;
use Illuminate\Auth\Access\Response;

class UserVerificationPackagesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض باقات التوثيق.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserVerificationPackages $userVerificationPackages): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض باقات التوثيق.');
        }
        return Response::allow();
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
    public function update(User $user, UserVerificationPackages $userVerificationPackages): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserVerificationPackages $userVerificationPackages): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserVerificationPackages $userVerificationPackages): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserVerificationPackages $userVerificationPackages): bool
    {
        return false;
    }

    public function updateStatus(User $user): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بالموافقة على الباقة.');
        }
        return Response::allow();
    }

}
