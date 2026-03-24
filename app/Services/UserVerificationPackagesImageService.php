<?php

namespace App\Services;

use App\Models\UserVerificationPackagesImage;
use Illuminate\Support\Facades\Storage;

class UserVerificationPackagesImageService
{
    public function uploadImages($userId, $packageId, $images)
    {
        $uploadedImages = [];

        foreach ($images as $image) {
            $path = $image->store('user_verification_images', 'public');
            
            $uploadedImages[] = UserVerificationPackagesImage::create([
                'user_id' => $userId,
                'package_id' => $packageId,
                'image_path' => $path,
            ]);
        }

        return $uploadedImages;
    }

    public function getImages($userId, $packageId)
    {
        return UserVerificationPackagesImage::where('user_id', $userId)
            ->where('package_id', $packageId)
            ->get();
    }

    public function deleteImage($id)
    {
        $image = UserVerificationPackagesImage::find($id);
        if ($image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
            return true;
        }
        return false;
    }
}
