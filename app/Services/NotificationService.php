<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class NotificationService
{
    /**
     * إرسال إشعار للموبايل واستخلاص التوكنات مباشرة من قاعدة البيانات
     * وحفظ الإشعار بجدول notifications
     *
     * @param int $userId (رقم المستخدم المستهدف)
     * @param string $title (عنوان الإشعار)
     * @param string $message (محتوى الإشعار)
     * @param string $type (نوع الإشعار، مثلاً: new_request)
     * @param array $data (بيانات إضافية للإشعار)
     * @return bool
     */
    public function sendToUser($userId, $title, $message, $type = 'general', $data = [])
    {
        // 1. جلب التوكنات الخاصة بالمستخدم من جدول device_tokens
        $tokens = \App\Models\DeviceTokens::where('user_id', $userId)->pluck('token')->toArray();

        // 2. إرسال الإشعار كـ Push Notification في حال وجود توكنات
        if (!empty($tokens)) {
            $this->sendPushNotification($tokens, $title, $message, $data);
        }

        // 3. حفظ الإشعار في قاعدة البيانات
        $notification = \App\Models\Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'is_read' => false,
        ]);

        return (bool) $notification;
    }

    /**
     * إرسال إشعار للموبايل باستخدام Firebase Cloud Messaging (FCM)
     *
     * @param string|array $fcmTokens (توكن الجهاز أو مصفوفة من التوكنز)
     * @param string $title (عنوان الإشعار)
     * @param string $body (محتوى الإشعار)
     * @param array $data (بيانات إضافية)
     * @return bool
     */
    public function sendPushNotification($fcmTokens, $title, $body, $data = [])
    {
        // يرجى إضافة FCM_SERVER_KEY في ملف .env
        $serverKey = env('FCM_SERVER_KEY');
        $url = 'https://fcm.googleapis.com/fcm/send';

        $tokens = is_array($fcmTokens) ? $fcmTokens : [$fcmTokens];

        $payload = [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
            ],
            'data' => $data,
        ];

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            if ($response->successful()) {
                \Illuminate\Support\Facades\Log::info('Notification sent successfully', $response->json());
                return true;
            }

            \Illuminate\Support\Facades\Log::error('Notification failed', ['response' => $response->body()]);
            return false;

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification Exception: ' . $e->getMessage());
            return false;
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->is_read = true;
            $notification->save();
        }
    }

    public function markAllAsRead($userId)
    {
        $notifications = Notification::where('user_id', $userId)->get();
        foreach ($notifications as $notification) {
            $notification->is_read = true;
            $notification->save();
        }
    }
}
