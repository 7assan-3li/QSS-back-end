<?php

namespace App\Policies;

use App\constant\BondStatus;
use App\constant\Role;
use App\Models\User;
use App\Models\WithdrawRequest;
use Illuminate\Auth\Access\Response;

class WithdrawRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {

        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WithdrawRequest $withdrawRequest): Response
    {
        if ($user->role !== Role::PROVIDER) {
            return Response::deny('غير مصرح لك بعرض طلب السحب.');
        }
        if ($user->id !== $withdrawRequest->user_id) {
            return Response::deny('غير مصرح لك بعرض طلب السحب.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->role !== Role::PROVIDER) {
            return Response::deny('غير مصرح لك بإنشاء طلب سحب.');
        }
        if ($user->paid_points <= 0) {
            return Response::deny('لا يمكن إنشاء طلب سحب.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WithdrawRequest $withdrawRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WithdrawRequest $withdrawRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WithdrawRequest $withdrawRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WithdrawRequest $withdrawRequest): bool
    {
        return false;
    }

    public function adminView(User $user): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض طلبات السحب.');
        }
        return Response::allow();
    }

    public function adminViewAny(User $user): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بعرض هذا الطلب.');
        }
        return Response::allow();
    }

    public function updateStatus(User $user, WithdrawRequest $withdrawRequest): Response
    {
        if ($user->role !== Role::EMPLOYEE) {
            return Response::deny('غير مصرح لك بتحديث حالة طلب السحب.');
        }
        if ($withdrawRequest->status !== BondStatus::PENDING) {
            return Response::deny('حالة الطلب ليست قيد الانتظار');
        }
        return Response::allow();
    }
}
