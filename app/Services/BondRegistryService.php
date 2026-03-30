<?php

namespace App\Services;

use App\Models\BondRegistry;
use App\constant\BondStatus;
use Exception;

class BondRegistryService
{
    /**
     * التحقق من السند وتسجيله مبدئياً بحالة Pending
     */
    public function register($userId, $bondNumber, $bankName, $amount, $sourceType, $sourceId, $imagePath = null)
    {
        // التحقق من عدم وجود السند مسبقاً (قاعدة البيانات ستمنع التكرار أيضاً بسبب Unique constraint)
        $exists = BondRegistry::where('bond_number', $bondNumber)
            ->where('bank_name', $bankName)
            ->exists();

        if ($exists) {
            throw new Exception('رقم السند هذا مسجل مسبقاً في النظام.');
        }

        // بصمة الصورة (اختياري)
        $imageHash = null;
        if ($imagePath && file_exists(storage_path('app/public/' . $imagePath))) {
            $imageHash = md5_file(storage_path('app/public/' . $imagePath));
            
            if (BondRegistry::where('image_hash', $imageHash)->exists()) {
                throw new Exception('صورة هذا السند تم استخدامها مسبقاً.');
            }
        }

        return BondRegistry::create([
            'user_id' => $userId,
            'bond_number' => $bondNumber,
            'bank_name' => $bankName,
            'amount' => $amount,
            'source_type' => $sourceType,
            'source_id' => $sourceId,
            'image_hash' => $imageHash,
            'status' => 'pending',
        ]);
    }

    /**
     * تحديث حالة السند إلى مقبولة Processed/Approved
     */
    public function approve($sourceType, $sourceId)
    {
        $bond = BondRegistry::where('source_type', $sourceType)
            ->where('source_id', $sourceId)
            ->first();

        if ($bond) {
            $bond->update(['status' => 'approved']);
        }
    }

    /**
     * إزالة السند عند الرفض ليتمكن المستخدم من استخدامه مجدداً (أو حذفه)
     */
    public function reject($sourceType, $sourceId)
    {
        $bond = BondRegistry::where('source_type', $sourceType)
            ->where('source_id', $sourceId)
            ->first();

        if ($bond) {
            $bond->delete(); // نحذفه من السجل المركزي ليتاح الرقم مجدداً إذا كان المستخدم أخطأ في الرقم فقط
        }
    }
}
