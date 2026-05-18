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

            // استثناء المسارات الخاصة بالعمولات والشكاوى من الفحص
            // حتى يتمكن المزود من الدفع أو رفع شكوى
            $excludedPaths = [
                'api/request-commission-bonds',
                'api/request-commission-bonds/*',
                'api/provider-commission-summary',
                'api/request-complaints',
                'api/request-complaints/*',
                'api/system-complaints',
                'api/system-complaints/*',
                'api/notifications',
                'api/notifications/*',
                'api/requests/unpaid-commissions',
                'api/requests/*/pay-commission',
                'api/requests/*/payByPoints',
                'api/requests/*/addAmountToMoneyPaid',
                'api/requests/*/finish',
                'api/requests/*/status',
            ];

            if ($request->is(...$excludedPaths)) {
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
