<?php

namespace App\Services;


use App\Models\PointsPackage;

class PointsPackageService
{
    public function getAllPackages($admin = false)
    {
        $query = PointsPackage::query();
        if (!$admin) {
            $query->where('is_active', true);
        }
        return $query->latest()->get();
    }

    public function getPackage($id)
    {
        return PointsPackage::findOrFail($id);
    }

    public function store($data)
    {
        return PointsPackage::create($data);
    }

    public function update($id, $data)
    {
        $package = PointsPackage::findOrFail($id);
        $package->update($data);
        return $package;
    }

    public function destroy($id)
    {
        $package = PointsPackage::findOrFail($id);
        return $package->delete();
    }

    public function toggleStatus($id)
    {
        $package = PointsPackage::findOrFail($id);
        $package->is_active = !$package->is_active;
        $package->save();
        return $package;
    }
}