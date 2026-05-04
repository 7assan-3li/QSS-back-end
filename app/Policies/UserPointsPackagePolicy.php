<?php

namespace App\Policies;

use App\constant\Role;
use App\Models\User;
use App\Models\UserPointsPackage;
use Illuminate\Auth\Access\Response;

class UserPointsPackagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض الباقات.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserPointsPackage $userPointsPackage): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض الباقة.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserPointsPackage $userPointsPackage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserPointsPackage $userPointsPackage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserPointsPackage $userPointsPackage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserPointsPackage $userPointsPackage): bool
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
