<?php

namespace App\Services;

use App\Models\DeviceTokens;
use Illuminate\Support\Facades\Log;

class DeviceTokenService
{
    /**
     * حفظ أو تحديث توكن الجهاز
     *
     * @param string $token
     * @param int|null $userId
     * @return DeviceTokens
     */
    public function storeToken($token, $userId = null)
    {
        try {
            // تحديث أو إنشاء التوكن
            return DeviceTokens::updateOrCreate(
                ['token' => $token],
                ['user_id' => $userId]
            );
        } catch (\Exception $e) {
            Log::error('Error storing device token: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * إزالة التوكن عند تسجيل الخروج مثلاً
     *
     * @param string $token
     * @return bool
     */
    public function removeToken($token)
    {
        return DeviceTokens::where('token', $token)->delete();
    }
}
