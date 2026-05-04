<?php

namespace App\Policies;

use App\constant\Role;
use App\constant\SystemComplaintStatus;
use App\Models\SystemComplaint;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SystemComplaintPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض الشكاوي.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SystemComplaint $systemComplaint): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض الشكوي.');
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
    public function update(User $user, SystemComplaint $systemComplaint): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SystemComplaint $systemComplaint): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SystemComplaint $systemComplaint): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SystemComplaint $systemComplaint): bool
    {
        return false;
    }

    public function updateStatus(User $user, SystemComplaint $systemComplaint): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بتحديث حالة الشكوي.');
        }
        return Response::allow();
    }
    public function exportDetailed(User $user): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بتصدير الشكاوي.');
        }
        return Response::allow();
    }
}
