<?php

namespace App\Http\Middleware;

use App\constant\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\constant\RequestStatus;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class CheckUnpaidCommissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // نتحقق إذا كان المستخدم مسجل دخول وهو مزود خدمة
        if ($user && $user->role === Role::PROVIDER) {

            $isSensitiveAction = false;

            // 1. قبول طلب جديد أو البدء فيه (تحديث الحالة إلى مقبول مبدئياً أو حالات الدفع المتقدمة)
            if ($request->is('api/requests/*/status') && $request->isMethod('patch')) {
                $newStatus = $request->input('status');
                if (in_array($newStatus, ['accepted_initial', 'accepted_partial_paid', 'accepted_full_paid'])) {
                    $isSensitiveAction = true;
                }
            }

            // 2. تحديد سعر طلب مخصص (والذي يعتبر قبولاً للطلب من طرف المزود)
            if ($request->is('api/requests/custom/*/price') && $request->isMethod('patch')) {
                $isSensitiveAction = true;
            }

            // 3. إنشاء أو تعديل الخدمات (إجراءات متعلقة بنشاط المزود)
            if ($request->is('api/services*') && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                $isSensitiveAction = true;
            }

            // إذا لم تكن العملية حساسة، نتجاوز الفحص لتسريع الأداء وعدم تقييد المستخدم في التصفح والملف الشخصي
            if (!$isSensitiveAction) {
                return $next($request);
            }

            // استدعاء الدالة من موديل User لحساب العمولات مع التخزين المؤقت (Cache)
            $unpaidCount = $user->getUnpaidCommissionsCount();

            // إذا كان عدد العمولات غير المدفوعة 3 أو أكثر
            if ($unpaidCount >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'عذراً، لا يمكنك الاستمرار لعدم سدادك 3 عمولات أو أكثر. يرجى سداد العمولات المستحقة لتتمكن من استقبال الطلبات وإدارة خدماتك.',
                    'error_code' => 'UNPAID_COMMISSIONS_LIMIT_REACHED'
                ], 403);
            }
        }

        return $next($request);
    }
}
