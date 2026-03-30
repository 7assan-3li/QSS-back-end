<?php

namespace App\Services;

use App\Models\UserPointsPackage;
use App\Models\User;
use App\constant\BondStatus;
use Illuminate\Support\Facades\DB;

class UserPointsPackageService
{
    public function __construct(private BondRegistryService $bondRegistryService) {}

    public function index($status = null)
    {
        $query = UserPointsPackage::with(['user', 'package', 'admin']);
        if ($status) {
            $query->where('status', $status);
        }
        return $query->latest()->paginate(10);
    }

    public function getUserPackages($userId)
    {
        return UserPointsPackage::with(['package', 'admin'])
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function purchase($userId, $data, $image)
    {
        $path = $image->store('package_bonds', 'public');
        
        return DB::transaction(function () use ($userId, $data, $path) {
            $userPackage = UserPointsPackage::create([
                'user_id' => $userId,
                'package_id' => $data['package_id'],
                'bond_image' => $path,
                'bond_number' => $data['bond_number'],
                'bank_name' => $data['bank_name'],
                'status' => BondStatus::PENDING,
            ]);

            // تسجيل في السجل المركزي
            $this->bondRegistryService->register(
                $userId, 
                $data['bond_number'], 
                $data['bank_name'], 
                null, // Amount can be added if available
                'points_package', 
                $userPackage->id,
                $path
            );

            return $userPackage;
        });
    }

    public function approve($id, $adminId)
    {
        return DB::transaction(function () use ($id, $adminId) {
            $userPackage = UserPointsPackage::with('package')->lockForUpdate()->findOrFail($id);
            
            if ($userPackage->status !== BondStatus::PENDING) {
                throw new \Exception('هذا الطلب تمت معالجته مسبقاً');
            }

            $user = User::lockForUpdate()->findOrFail($userPackage->user_id);
            
            // إضافة النقاط (الأساسية + الإضافية)
            $totalPoints = $userPackage->package->points + $userPackage->package->bonus_points;
            $user->bonus_points += $totalPoints;
            
            $userPackage->update([
                'status' => BondStatus::APPROVED,
                'admin_id' => $adminId,
            ]);

            $user->save();

            // تحديث السجل المركزي
            $this->bondRegistryService->approve('points_package', $userPackage->id);

            // تسجيل العملية في سجل النقاط
            \App\Models\PointTransaction::create([
                'seeker_id' => $user->id,
                'provider_id' => null,
                'request_id' => null,
                'amount' => $totalPoints,
                'type' => 'package_purchase',
            ]);

            return $userPackage;
        });
    }

    public function reject($id, $adminId, $note)
    {
        return DB::transaction(function () use ($id, $adminId, $note) {
            $userPackage = UserPointsPackage::findOrFail($id);
            
            if ($userPackage->status !== BondStatus::PENDING) {
                throw new \Exception('هذا الطلب تمت معالجته مسبقاً');
            }

            $userPackage->update([
                'status' => BondStatus::REJECTED,
                'admin_id' => $adminId,
                'admin_note' => $note,
            ]);
            
            // إزالة من السجل المركزي ليتاح الرقم مجدداً إذا كان خطأ
            $this->bondRegistryService->reject('points_package', $userPackage->id);
            
            return $userPackage;
        });
    }
}