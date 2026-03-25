<?php

namespace App\Services;

use App\Models\WithdrawRequest;
use App\Models\User;
use App\constant\BondStatus;
use Illuminate\Support\Facades\DB;

class WithdrawRequestService
{
    public function indexAdmin($status = null)
    {
        $query = WithdrawRequest::with(['user', 'admin']);
        if ($status) {
            $query->where('status', $status);
        }
        return $query->latest()->paginate(10);
    }

    public function indexUser($userId)
    {
        return WithdrawRequest::where('user_id', $userId)->latest()->get();
    }

    public function store($userId, $amount)
    {
        return DB::transaction(function () use ($userId, $amount) {
            $user = User::lockForUpdate()->findOrFail($userId);

            if ($user->paid_points < $amount) {
                throw new \Exception('رصيد النقاط المتاحة للسحب غير كافٍ');
            }

            if ($amount <= 0) {
                throw new \Exception('المبلغ يجب أن يكون أكبر من الصفر');
            }

            return WithdrawRequest::create([
                'user_id' => $userId,
                'amount' => $amount,
                'status' => BondStatus::PENDING,
            ]);
        });
    }

    public function approve($id, $adminId, $bondImage, $bondNumber)
    {
        return DB::transaction(function () use ($id, $adminId, $bondImage, $bondNumber) {
            $request = WithdrawRequest::lockForUpdate()->findOrFail($id);

            if ($request->status !== BondStatus::PENDING) {
                throw new \Exception('هذا الطلب تمت معالجته مسبقاً');
            }

            $user = User::lockForUpdate()->findOrFail($request->user_id);

            if ($user->paid_points < $request->amount) {
                throw new \Exception('رصيد المستخدم لم يعد كافياً لإتمام عملية السحب');
            }

            // خصم النقاط
            $user->paid_points -= $request->amount;
            $user->save();

            // حفظ صورة السند
            $imagePath = $bondImage->store('withdraw_bonds', 'public');

            // تحديث الطلب
            $request->update([
                'status' => BondStatus::APPROVED,
                'admin_id' => $adminId,
                'bond_image' => $imagePath,
                'bond_number' => $bondNumber,
            ]);

            // تسجيل العملية في سجل النقاط
            \App\Models\PointTransaction::create([
                'seeker_id' => $user->id, 
                'provider_id' => null,
                'request_id' => null,
                'amount' => $request->amount,
                'type' => 'withdrawal',
            ]);

            return $request;
        });
    }

    public function reject($id, $adminId, $note)
    {
        $request = WithdrawRequest::findOrFail($id);

        if ($request->status !== BondStatus::PENDING) {
            throw new \Exception('هذا الطلب تمت معالجته مسبقاً');
        }

        $request->update([
            'status' => BondStatus::REJECTED,
            'admin_id' => $adminId,
            'admin_note' => $note,
        ]);

        return $request;
    }
}
