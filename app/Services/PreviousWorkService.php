<?php

namespace App\Services;
use App\Models\PreviousWork;
use Auth;
use Illuminate\Support\Facades\Storage;
class PreviousWorkService
{
    public function create(array $data, $request)
    {
        $user = Auth::user();

        if (!$user->profile) {
            throw new \Exception('User does not have a profile.');
        }

        // 📷 حفظ الصورة
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('previous_works', 'public');
        }

        if (!$imagePath) {
            throw new \Exception('Image is required for previous work.');
        }

        $previousWork = PreviousWork::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image_path' => $imagePath,
            'profile_id' => $user->profile->id,
        ]);

        return $previousWork;
    }
    public function update(array $data, $request, int $previousWorkId)
    {
        $user = Auth::user();

        if (!$user->profile) {
            throw new \Exception('User does not have a profile.');
        }

        $previousWork = PreviousWork::where('id', $previousWorkId)
            ->where('profile_id', $user->profile->id)
            ->firstOrFail();

        // 📷 في حال تم إرسال صورة جديدة
        if ($request->hasFile('image')) {
            // 🗑️ حذف الصورة القديمة إن وجدت
            if ($previousWork->image_path && Storage::disk('public')->exists($previousWork->image_path)) {
                Storage::disk('public')->delete($previousWork->image_path);
            }


            // 💾 حفظ الصورة الجديدة
            $data['image_path'] = $request->file('image')->store('previous_works', 'public');
        }

        // إزالة الحقول التي لا تنتمي لقاعدة البيانات (مثل ملف الصورة الأصلي)
        unset($data['image']);

        // ✏️ تحديث البيانات
        $previousWork->update($data);

        return $previousWork->fresh();
    }

    public function delete(int $previousWorkId)
    {
        $user = Auth::user();

        if (!$user->profile) {
            throw new \Exception('User does not have a profile.');
        }

        $previousWork = PreviousWork::where('id', $previousWorkId)
            ->where('profile_id', $user->profile->id)
            ->firstOrFail();

        // 🗑️ حذف الصورة من التخزين
        if ($previousWork->image_path && Storage::disk('public')->exists($previousWork->image_path)) {
            Storage::disk('public')->delete($previousWork->image_path);
        }

        // 🗑️ حذف السجل من قاعدة البيانات
        $previousWork->delete();

        return true;
    }
}