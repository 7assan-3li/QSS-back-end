<?php

namespace App\Services;

use App\Models\UserVerificationPackages;
use App\constant\BondStatus;
use Illuminate\Support\Facades\DB;

class UserVerificationPackagesService
{
    public function __construct(private BondRegistryService $bondRegistryService) {}

    /**
     * Get all packages for a specific user
     */
    public function getUserPackages($userId)
    {
        return UserVerificationPackages::with(['verificationPackage'])
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * Get all packages for admin
     */
    public function getAllPackages()
    {
        return UserVerificationPackages::with(['user', 'verificationPackage', 'admin'])
            ->latest()
            ->get();
    }

    /**
     * Store a new user verification package request
     */
    public function storePackage($userId, array $data, $imageFile)
    {
        return DB::transaction(function () use ($userId, $data, $imageFile) {
            $path = $imageFile->store('user_verification_images', 'public');

            $userPackage = UserVerificationPackages::create([
                'user_id' => $userId,
                'verification_package_id' => $data['verification_package_id'],
                'image_bond' => $path,
                'number_bond' => $data['number_bond'],
                'status' => BondStatus::PENDING,
            ]);

            // تسجيل في السجل المركزي
            $this->bondRegistryService->register(
                $userId,
                $data['number_bond'],
                null, // Bank name
                null,
                'verification',
                $userPackage->id,
                $path
            );

            return $userPackage;
        });
    }

    /**
     * Approve a package request
     */
    public function approvePackage($packageId, $adminId)
    {
        return DB::transaction(function () use ($packageId, $adminId) {
            $userPackage = UserVerificationPackages::findOrFail($packageId);
            
            $userPackage->update([
                'status' => BondStatus::APPROVED,
                'admin_id' => $adminId,
            ]);

            $currentDate = $userPackage->user->provider_verified_until ? \Carbon\Carbon::parse($userPackage->user->provider_verified_until) : null;
            $startDate = ($currentDate && $currentDate->isFuture()) ? $currentDate : now();
            $newDate = $startDate->addDays($userPackage->verificationPackage->duration_days);

            $userPackage->user->update([
                'verification_provider' => true,
                'provider_verified_until' => $newDate
            ]);

            // تحديث السجل المركزي
            $this->bondRegistryService->approve('verification', $userPackage->id);

            return $userPackage;
        });
    }

    /**
     * Reject a package request
     */
    public function rejectPackage($packageId, $adminId)
    {
        return DB::transaction(function () use ($packageId, $adminId) {
            $userPackage = UserVerificationPackages::findOrFail($packageId);
            
            $userPackage->update([
                'status' => BondStatus::REJECTED,
                'admin_id' => $adminId,
            ]);

            // إزالة من السجل المركزي
            $this->bondRegistryService->reject('verification', $userPackage->id);

            return $userPackage;
        });
    }

    /**
     * Get details of a single package request
     */
    public function getPackageDetails($packageId)
    {
        return UserVerificationPackages::with(['user', 'verificationPackage', 'admin'])
            ->findOrFail($packageId);
    }
}
