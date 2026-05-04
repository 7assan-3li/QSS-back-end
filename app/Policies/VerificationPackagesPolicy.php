<?php

namespace App\Policies;

use App\constant\Role;
use App\Models\User;
use App\Models\VerificationPackages;
use Illuminate\Auth\Access\Response;

class VerificationPackagesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->role !== Role::ADMIN) {
            return Response::deny('غير مصرح لك بعرض الباقات.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, VerificationPackages $verificationPackages): Response
    {
        if ($user->role !== Role::ADMIN) {
            return Response::deny('غير مصرح لك بعرض الباقة.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->role !== Role::ADMIN) {
            return Response::deny('غير مصرح لك بإنشاء باقة.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, VerificationPackages $verificationPackages): Response
    {
        if ($user->role !== Role::ADMIN) {
            return Response::deny('غير مصرح لك بتحديث الباقة.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, VerificationPackages $verificationPackages): Response
    {
        if ($user->role !== Role::ADMIN) {
            return Response::deny('غير مصرح لك بحذف الباقة.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, VerificationPackages $verificationPackages): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, VerificationPackages $verificationPackages): bool
    {
        return false;
    }
}
