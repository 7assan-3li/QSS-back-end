<?php

namespace App\Services;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class ProfileService
{

    public function create(array $data, $request): Profile
    {
        // 📷 حفظ الصورة
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('profiles', 'public');
        }

        // 👤 إنشاء الملف الشخصي
        return Profile::create([
            'user_id' => Auth::user()->id,
            'bio' => $data['bio'] ?? null,
            'image_path' => $imagePath,
        ]);
    }


    public function update($data, $request, $profile_id): Profile
    {
        $profile = Profile::findOrFail($profile_id);

        // 🖼️ في حال تم إرسال صورة جديدة
        if ($request->hasFile('image')) {

            // 🗑️ حذف الصورة القديمة إن وُجدت
            if (
                $profile->image_path &&
                Storage::disk('public')->exists($profile->image_path)
            ) {
                Storage::disk('public')->delete($profile->image_path);
            }

            // 💾 حفظ الصورة الجديدة
            $profile->image_path = $request->file('image')
                ->store('profiles', 'public');
        }

        // ✏️ تحديث البيانات الأخرى
        $profile->update([
            'bio' => $data['bio'] ?? $profile->bio,
        ]);

        return $profile;
    }
}
