<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(\App\Services\NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // جلب الإشعارات للمستخدم الحالي
    public function index()
    {
        $notifications = \App\Models\Notification::where('user_id', auth('sanctum')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $notifications]);
    }

    // تعيين إشعار محدد كمقروء
    public function markAsRead($id)
    {
        $this->notificationService->markAsRead($id);
        return response()->json(['message' => 'Notification marked as read']);
    }

    // تعيين جميع الإشعارات كمقروءة للمستخدم
    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead(auth('sanctum')->id());
        return response()->json(['message' => 'All notifications marked as read']);
    }
}
