<?php

namespace App\Policies;

use App\constant\Role;
use App\Models\PointsPackage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PointsPackagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->role !== Role::ADMIN ) {
            return Response::deny('غير مصرح لك بعرض الباقات.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PointsPackage $pointsPackage): Response
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
    public function update(User $user, PointsPackage $pointsPackage): Response
    {
        if ($user->role !== Role::ADMIN) {
            return Response::deny('غير مصرح لك بتحديث الباقة.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PointsPackage $pointsPackage): Response
    {
        if ($user->role !== Role::ADMIN) {
            return Response::deny('غير مصرح لك بحذف الباقة.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PointsPackage $pointsPackage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PointsPackage $pointsPackage): bool
    {
        return false;
    }
}
