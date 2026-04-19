<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Constants\NotificationType;

class NotificationService
{
    /**
     * إرسال إشعار للموبايل واستخلاص التوكنات مباشرة من قاعدة البيانات
     * وحفظ الإشعار بجدول notifications
     *
     * @param int $userId (رقم المستخدم المستهدف)
     * @param string $title (عنوان الإشعار)
     * @param string $message (محتوى الإشعار)
     * @param string $type (نوع الإشعار، استخدم Constants\NotificationType)
     * @param array $data (بيانات إضافية للإشعار)
     * @return bool
     */
    public function sendToUser($userId, $title, $message, $type = NotificationType::GENERAL, $data = [])
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
     * إرسال إشعار للموبايل باستخدام Firebase Cloud Messaging (FCM) - HTTP v1
     *
     * @param string|array $fcmTokens (توكن الجهاز أو مصفوفة من التوكنز)
     * @param string $title (عنوان الإشعار)
     * @param string $body (محتوى الإشعار)
     * @param array $data (بيانات إضافية)
     * @return bool
     */
    public function sendPushNotification($fcmTokens, $title, $body, $data = [])
    {
        try {
            $messaging = app('firebase.messaging');
            $tokens = is_array($fcmTokens) ? $fcmTokens : [$fcmTokens];

            if (empty($tokens)) {
                return false;
            }

            $notification = \Kreait\Firebase\Messaging\Notification::create($title, $body);
            
            $message = \Kreait\Firebase\Messaging\CloudMessage::new()
                ->withNotification($notification)
                ->withData($data);

            $sendReport = $messaging->sendMulticast($message, $tokens);

            if ($sendReport->hasFailures()) {
                foreach ($sendReport->failures()->getItems() as $failure) {
                    \Illuminate\Support\Facades\Log::error('FCM Notification failure: ' . $failure->error()->getMessage());
                }
            }

            \Illuminate\Support\Facades\Log::info('FCM Notifications processed', [
                'success_count' => $sendReport->successes()->count(),
                'failure_count' => $sendReport->failures()->count(),
            ]);

            return $sendReport->successes()->count() > 0;

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Firebase Notification Exception: ' . $e->getMessage());
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
