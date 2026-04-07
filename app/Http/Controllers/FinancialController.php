<?php

namespace App\Http\Controllers;

use App\Models\UserPointsPackage;
use App\Models\WithdrawRequest;
use App\Models\Request as RequestModel;
use App\Models\UserVerificationPackages;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialController extends Controller
{
    /**
     * Display the financial dashboard with advanced accounting analytics.
     */
    public function index(Request $request)
    {
        // 1. Date Range Handling
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date'))->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date'))->endOfDay() : Carbon::now()->endOfDay();

        // Calculate Previous Period for comparisons
        $durationInDays = $fromDate->diffInDays($toDate) + 1;
        $prevFromDate = (clone $fromDate)->subDays($durationInDays);
        $prevToDate = (clone $fromDate)->subSecond();

        // 2. Main Metrics (Current vs Previous)
        $metrics = $this->getFinancialMetrics($fromDate, $toDate);
        $prevMetrics = $this->getFinancialMetrics($prevFromDate, $prevToDate);

        // Calculate Percentage Trends
        $trends = [
            'inflow' => $this->calculateTrend($metrics['totalInflow'], $prevMetrics['totalInflow']),
            'outflow' => $this->calculateTrend($metrics['totalOutflow'], $prevMetrics['totalOutflow']),
            'profit' => $this->calculateTrend($metrics['totalProfit'], $prevMetrics['totalProfit']),
            'verification' => $this->calculateTrend($metrics['verificationRevenue'], $prevMetrics['verificationRevenue']),
        ];

        // 3. Top Performing Services (by Commission)
        $topServices = RequestModel::join('request_service', 'requests.id', '=', 'request_service.request_id')
            ->where('request_service.is_main', true)
            ->join('services', 'request_service.service_id', '=', 'services.id')
            ->whereBetween('requests.created_at', [$fromDate, $toDate])
            ->select(
                'services.id',
                'services.name',
                DB::raw('COUNT(requests.id) as request_count'),
                DB::raw('SUM(requests.commission_amount) as total_commission')
            )
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('total_commission')
            ->take(5)
            ->get();

        // 4. Financial Alerts
        $alerts = [];
        $highPendingWithdrawals = WithdrawRequest::where('status', 'pending')->sum('amount');
        if ($highPendingWithdrawals > 5000) {
            $alerts[] = [
                'type' => 'warning',
                'title' => __('تنبيه سيولة نقدية'),
                'message' => __('توجد طلبات سحب معلقة بمجموع :amount ر.س. يرجى التأكد من توفر الرصيد الكافي.', ['amount' => number_format($highPendingWithdrawals, 2)])
            ];
        }

        $overdueCommissions = RequestModel::where('status', 'completed')
            ->where('commission_paid', false)
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->count();
        if ($overdueCommissions > 0) {
            $alerts[] = [
                'type' => 'danger',
                'title' => __('تأخر تحصيل عمولات'),
                'message' => __('يوجد :count طلبات مكتملة منذ أكثر من 7 أيام ولم يتم تحصيل عمولتها بعد.', ['count' => $overdueCommissions])
            ];
        }

        // 5. Chart Data (Contextual 6 Months)
        $sixMonthsAgo = Carbon::now()->subMonths(6)->startOfMonth();
        $monthlyData = $this->getMonthlyTrendData($sixMonthsAgo);

        // 6. Detailed Tables (Paginated)
        $detailedInflows = UserPointsPackage::where('status', 'approved')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->with(['user', 'package'])
            ->latest()
            ->paginate(8, ['*'], 'inflow_page');

        $detailedOutflows = WithdrawRequest::where('status', 'approved')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->with(['user', 'admin'])
            ->latest()
            ->paginate(8, ['*'], 'outflow_page');

        return view('admin.financial.index', array_merge(
            $metrics,
            compact('trends', 'topServices', 'alerts', 'detailedInflows', 'detailedOutflows', 'fromDate', 'toDate'),
            $monthlyData
        ));
    }

    private function getFinancialMetrics($from, $to)
    {
        $totalInflow = UserPointsPackage::where('status', 'approved')
            ->whereBetween('created_at', [$from, $to])
            ->with('package')
            ->get()
            ->sum(fn($up) => $up->package->price ?? 0);

        $totalOutflow = WithdrawRequest::where('status', 'approved')
            ->whereBetween('created_at', [$from, $to])
            ->sum('amount');

        $paidCommissions = RequestModel::where('commission_paid', true)
            ->whereBetween('created_at', [$from, $to])
            ->sum('commission_amount');

        $accruedCommissions = RequestModel::where('commission_paid', false)
            ->where('commission_amount', '>', 0)
            ->whereBetween('created_at', [$from, $to])
            ->sum('commission_amount');

        $verificationRevenue = UserVerificationPackages::where('status', 'approved')
            ->whereBetween('created_at', [$from, $to])
            ->with('verificationPackage')
            ->get()
            ->sum(fn($uv) => $uv->verificationPackage->price ?? 0);

        return [
            'totalInflow' => (float)$totalInflow,
            'totalOutflow' => (float)$totalOutflow,
            'paidCommissions' => (float)$paidCommissions,
            'accruedCommissions' => (float)$accruedCommissions,
            'verificationRevenue' => (float)$verificationRevenue,
            'totalProfit' => (float)($paidCommissions + $verificationRevenue)
        ];
    }

    private function calculateTrend($current, $previous)
    {
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function getMonthlyTrendData($start)
    {
        $monthlyInflow = UserPointsPackage::where('status', 'approved')
            ->where('created_at', '>=', $start)
            ->with('package')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y-m'))
            ->map(fn($group) => $group->sum(fn($up) => $up->package->price ?? 0));

        $monthlyOutflow = WithdrawRequest::where('status', 'approved')
            ->where('created_at', '>=', $start)
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y-m'))
            ->map(fn($group) => $group->sum('amount'));

        $chartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $chartLabels[] = Carbon::now()->subMonths($i)->format('Y-m');
        }

        return [
            'formattedInflow' => collect($chartLabels)->mapWithKeys(fn($date) => [$date => $monthlyInflow->get($date, 0)]),
            'formattedOutflow' => collect($chartLabels)->mapWithKeys(fn($date) => [$date => $monthlyOutflow->get($date, 0)])
        ];
    }
}
