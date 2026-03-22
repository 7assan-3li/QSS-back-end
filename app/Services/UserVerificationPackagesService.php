<?php

namespace App\Services;

use App\Models\UserVerificationPackages;
use App\constant\BondStatus;

class UserVerificationPackagesService
{
    /**
     * Get all packages for a specific user
     */
    public function getUserPackages($userId)
    {
        return UserVerificationPackages::with('verificationPackage')
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
    public function storePackage($userId, array $data, $imageFile = null)
    {
        if ($imageFile) {
            $data['image_bond'] = $imageFile->store('verification_bonds', 'public');
        }

        return UserVerificationPackages::create([
            'user_id' => $userId,
            'verification_package_id' => $data['verification_package_id'],
            'image_bond' => $data['image_bond'] ?? null,
            'number_bond' => $data['number_bond'],
            'status' => BondStatus::PENDING,
        ]);
    }

    /**
     * Approve a package request
     */
    public function approvePackage($packageId, $adminId)
    {
        $userPackage = UserVerificationPackages::findOrFail($packageId);
        
        $userPackage->update([
            'status' => BondStatus::APPROVED,
            'admin_id' => $adminId,
        ]);

        $currentDate = $userPackage->user->provider_verified_until ? \Carbon\Carbon::parse($userPackage->user->provider_verified_until) : null;
        $startDate = ($currentDate && $currentDate->isFuture()) ? $currentDate : now();
        $newDate = $startDate->addDays($userPackage->verificationPackage->duration_days);

        $userPackage->user->update([
            'provider_verified_until' => $newDate
        ]);

        return $userPackage;
    }

    /**
     * Reject a package request
     */
    public function rejectPackage($packageId, $adminId)
    {
        $userPackage = UserVerificationPackages::findOrFail($packageId);
        
        $userPackage->update([
            'status' => BondStatus::REJECTED,
            'admin_id' => $adminId,
        ]);

        return $userPackage;
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
