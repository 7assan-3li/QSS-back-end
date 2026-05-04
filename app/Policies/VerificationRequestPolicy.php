<?php

namespace App\Policies;

use App\constant\Role;
use App\constant\VerificationRequestStatus;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Auth\Access\Response;

class VerificationRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->role !== Role::PROVIDER) {
            return Response::deny('غير مصرح لك بعرض الطلبات.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, VerificationRequest $verificationRequest): Response
    {
        if ($user->role !== Role::PROVIDER ) {
            return Response::deny('غير مصرح لك بعرض الطلب.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->role !== Role::PROVIDER) {
            return Response::deny('غير مصرح لك بإنشاء طلب.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, VerificationRequest $verificationRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, VerificationRequest $verificationRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, VerificationRequest $verificationRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, VerificationRequest $verificationRequest): bool
    {
        return false;
    }

    public function adminViewAny(User $user): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض الطلبات.');
        }
        return Response::allow();
    }

    public function adminView(User $user, VerificationRequest $verificationRequest): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض الطلب.');
        }
        return Response::allow();
    }

    public function updateStatus(User $user, VerificationRequest $verificationRequest): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بتحديث حالة الطلب.');
        }
        if ($verificationRequest->status !== VerificationRequestStatus::PENDING) {
            return Response::deny('لا يمكن تحديث حالة الطلب لأنه ليس في حالة الانتظار.');
        }
        return Response::allow();
    }
}
