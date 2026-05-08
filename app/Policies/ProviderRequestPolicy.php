<?php

namespace App\Policies;

use App\constant\ProviderRequestStatus;
use App\constant\Role;
use App\Models\ProviderRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProviderRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض الطلبات.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProviderRequest $providerRequest): Response
    {
        if ($user->id !== $providerRequest->user_id) {
            return Response::deny('غير مصرح لك بعرض هذا الطلب.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->role !== Role::SEEKER) {
            return Response::deny('غير مصرح لك بإنشاء طلب.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProviderRequest $providerRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProviderRequest $providerRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProviderRequest $providerRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProviderRequest $providerRequest): bool
    {
        return false;
    }

    //admin functions
    public function adminViewAny(User $user): Response{
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض الطلبات.');
        }
        return Response::allow();
    }

    public function adminView(User $user, ProviderRequest $providerRequest): Response{
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض هذا الطلب.');
        }
        return Response::allow();
    }

    public function updateStatus(User $user, ProviderRequest $providerRequest): Response{
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بتحديث حالة الطلب.');
        }
        if ($providerRequest->status !== ProviderRequestStatus::PENDING) {
            return Response::deny('لا يمكن تحديث حالة الطلب لأنه ليس في حالة الانتظار.');
        }
        return Response::allow();
    }
}