<?php

namespace App\Services;
use App\Models\PreviousWork;
use Auth;
use Illuminate\Support\Facades\Storage;
class PreviousWorkService
{
    public function create(array $data, $request)
    {
        $user = $request->user();

        if (!$user || !$user->profile) {
            abort(403, 'User does not have a profile.');
        }

        // 📷 حفظ الصورة
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('previous_works', 'public');
        }

        if (!isset($data['image_path'])) {
            abort(400, 'Image is required for previous work.');
        }

        // إزالة الصورة من مصفوفة البيانات (لتتوافق مع الإنشاء المباشر)
        unset($data['image']);
        
        // التأكد من أن الوصف لا يسبب خطأ إذا كان غير موجود
        $data['description'] = $data['description'] ?? null;
        
        $data['profile_id'] = $user->profile->id;

        $previousWork = PreviousWork::create($data);

        return $previousWork;
    }
    public function update(array $data, $request, int $previousWorkId)
    {
        $user = $request->user();

        if (!$user || !$user->profile) {
            abort(403, 'User does not have a profile.');
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

    public function delete($request, int $previousWorkId)
    {
        $user = $request->user();

        if (!$user || !$user->profile) {
            abort(403, 'User does not have a profile.');
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