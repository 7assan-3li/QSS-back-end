<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;
use App\Models\Service;
use App\constant\RequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProviderDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'provider') {
            return response()->json(['message' => 'Unauthorized. Only providers can access this dashboard.'], 403);
        }

        // 1. عدد الخدمات الرئيسية فقط
        $totalServices = $user->services()
            ->where('type', \App\constant\ServiceType::MAIN)
            ->whereNull('parent_service_id')
            ->count();

        // 2. عدد الطلبات لكل خدمة رئيسية فقط + الخدمات الأكثر طلباً
        $servicesStats = $user->services()
            ->where('type', \App\constant\ServiceType::MAIN)
            ->whereNull('parent_service_id')
            ->withCount(['requests'])
            ->orderBy('requests_count', 'desc')
            ->get(['id', 'name', 'price']);

        $mostRequestedServices = $servicesStats->take(5);

        // 3. عدد الطلبات بالكامل (المقبولة أو المكتملة - استبعاد الملغية والمرفوضة)
        $totalRequests = RequestModel::whereHas('services', function ($query) use ($user) {
            $query->where('provider_id', $user->id);
        })
        ->whereNotIn('status', [RequestStatus::CANCELLED, RequestStatus::REJECTED])
        ->count();

        // 4. عرض الطلبات الجديدة (Pending)
        $newRequests = RequestModel::whereHas('services', function ($query) use ($user) {
            $query->where('provider_id', $user->id);
        })
        ->with(['user:id,name,email', 'main_service:id,name'])
        ->where('status', RequestStatus::PENDING)
        ->latest()
        ->get();

        // 5. حالة التوثيق وعدد أيام التوثيق
        $verificationStatus = $user->isVerified() ? 'verified' : 'not_verified';
        $verificationDaysLeft = null;
        if ($user->provider_verified_until) {
            // حساب الأيام المتبقية بشكل أدق (تقريب للأعلى)
            $diffInHours = now()->diffInHours($user->provider_verified_until, false);
            $verificationDaysLeft = $diffInHours > 0 ? ceil($diffInHours / 24) : 0;
        } elseif ($user->verification_provider) {
            $verificationDaysLeft = 'unlimited';
        }

        // 6. الدخل (أسبوعي، شهري، سنوي)
        // ملاحظة: تم استخدام updated_at لأنها تعكس وقت اكتمال الطلب
        $incomeWeekly = $this->calculateIncome($user->id, now()->subDays(7), now());
        $incomeMonthly = $this->calculateIncome($user->id, now()->subDays(30), now());
        $incomeYearly = $this->calculateIncome($user->id, now()->subDays(365), now());

        // 7. العمولات
        $unpaidRequests = RequestModel::whereHas('services', function ($query) use ($user) {
            $query->where('provider_id', $user->id);
        })
        ->where('status', RequestStatus::COMPLETED)
        ->where('commission_paid', false)
        ->with(['user:id,name'])
        ->get();

        $totalCommissionOwed = $unpaidRequests->sum(function ($req) {
            // التأكد من حساب العمولة إذا كانت 0 في قاعدة البيانات لسبب ما
            $amount = $req->commission_amount > 0 ? $req->commission_amount : $req->getCommissionAmount();
            return $amount - $req->commission_amount_paid;
        });

        // 8. الطلبات النشطة (المقبولة ولم تكتمل بعد)
        $activeRequestsCount = RequestModel::whereHas('services', function ($query) use ($user) {
            $query->where('provider_id', $user->id);
        })
        ->whereIn('status', [
            RequestStatus::ACCEPTED_INITIAL,
            RequestStatus::ACCEPTED_PARTIAL_PAID,
            RequestStatus::ACCEPTED_FULL_PAID
        ])
        ->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_services' => $totalServices,
                'total_requests' => $totalRequests,
                'active_requests_count' => $activeRequestsCount,
                'verification' => [
                    'status' => $verificationStatus,
                    'days_left' => $verificationDaysLeft,
                    'verified_until' => $user->provider_verified_until ? $user->provider_verified_until->format('Y-m-d H:i') : null,
                ],
                'income' => [
                    'weekly' => round($incomeWeekly, 2),
                    'monthly' => round($incomeMonthly, 2),
                    'yearly' => round($incomeYearly, 2),
                ],
                'commissions' => [
                    'total_owed' => round($totalCommissionOwed, 2),
                    'unpaid_requests_count' => $unpaidRequests->count(),
                    'unpaid_requests' => $unpaidRequests->map(function($req) {
                        return [
                            'id' => $req->id,
                            'customer_name' => $req->user?->name,
                            'total_price' => $req->total_price,
                            'commission_amount' => $req->commission_amount > 0 ? $req->commission_amount : $req->getCommissionAmount(),
                            'paid_so_far' => $req->commission_amount_paid,
                            'remaining_commission' => ($req->commission_amount > 0 ? $req->commission_amount : $req->getCommissionAmount()) - $req->commission_amount_paid,
                            'date' => $req->created_at->format('Y-m-d'),
                        ];
                    }),
                ],
                'services_performance' => [
                    'most_requested' => $mostRequestedServices->map(function($s) {
                        return [
                            'id' => $s->id,
                            'name' => $s->name,
                            'requests_count' => $s->requests_count,
                            'price' => $s->price
                        ];
                    }),
                    'all_services_counts' => $servicesStats->map(function($s) {
                        return [
                            'id' => $s->id,
                            'name' => $s->name,
                            'requests_count' => $s->requests_count
                        ];
                    }),
                ],
                'new_requests' => $newRequests->map(function($req) {
                    return [
                        'id' => $req->id,
                        'customer_name' => $req->user?->name,
                        'main_service' => $req->main_service->first()?->name,
                        'total_price' => $req->total_price,
                        'created_at' => $req->created_at->format('Y-m-d H:i'),
                    ];
                })
            ]
        ]);
    }

    private function calculateIncome($providerId, $startDate, $endDate)
    {
        return (float) RequestModel::whereHas('services', function ($query) use ($providerId) {
            $query->where('provider_id', $providerId);
        })
        ->where('status', RequestStatus::COMPLETED)
        ->whereBetween('updated_at', [$startDate, $endDate])
        ->sum('total_price');
    }
}
