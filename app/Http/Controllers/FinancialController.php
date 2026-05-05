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
            'totalInflow' => $this->calculateTrend($metrics['totalInflow'], $prevMetrics['totalInflow']),
            'pointsRevenue' => $this->calculateTrend($metrics['pointsRevenue'], $prevMetrics['pointsRevenue']),
            'verificationRevenue' => $this->calculateTrend($metrics['verificationRevenue'], $prevMetrics['verificationRevenue']),
            'commissionRevenue' => $this->calculateTrend($metrics['paidCommissions'], $prevMetrics['paidCommissions']),
            'totalOutflow' => $this->calculateTrend($metrics['totalOutflow'], $prevMetrics['totalOutflow']),
            'totalProfit' => $this->calculateTrend($metrics['totalProfit'], $prevMetrics['totalProfit']),
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
                'message' => __('توجد طلبات سحب معلقة بمجموع :amount ر.ي. يرجى التأكد من توفر الرصيد الكافي.', ['amount' => number_format($highPendingWithdrawals, 2)])
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

        // 6. Detailed Tables (Paginated independently)
        $detailedPoints = UserPointsPackage::where('status', 'approved')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->with(['user', 'package'])
            ->latest()
            ->paginate(10, ['*'], 'page_points');

        $detailedVerifications = UserVerificationPackages::where('status', 'approved')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->with(['user', 'verificationPackage'])
            ->latest()
            ->paginate(10, ['*'], 'page_verif');

        $detailedWithdrawals = WithdrawRequest::where('status', 'approved')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->with(['user', 'admin'])
            ->latest()
            ->paginate(10, ['*'], 'page_withdraw');

        return view('admin.financial.index', array_merge(
            $metrics,
            compact('trends', 'topServices', 'alerts', 'detailedPoints', 'detailedVerifications', 'detailedWithdrawals', 'fromDate', 'toDate'),
            $monthlyData
        ));
    }

    private function getFinancialMetrics($from, $to)
    {
        $pointsRevenue = UserPointsPackage::where('status', 'approved')
            ->whereBetween('created_at', [$from, $to])
            ->with('package')
            ->get()
            ->sum(fn($up) => $up->package->price ?? 0);

        $verificationRevenue = UserVerificationPackages::where('status', 'approved')
            ->whereBetween('created_at', [$from, $to])
            ->with('verificationPackage')
            ->get()
            ->sum(fn($uv) => $uv->verificationPackage->price ?? 0);

        $paidCommissions = RequestModel::whereBetween('created_at', [$from, $to])
            ->sum('commission_amount_paid');

        $totalOutflow = WithdrawRequest::where('status', 'approved')
            ->whereBetween('created_at', [$from, $to])
            ->sum('amount');

        $totalInflow = $pointsRevenue + $verificationRevenue + $paidCommissions;

        $accruedCommissions = RequestModel::where('commission_paid', false)
            ->whereBetween('created_at', [$from, $to])
            ->select(DB::raw('SUM(commission_amount - commission_amount_paid) as unpaid'))
            ->first()->unpaid ?? 0;

        // New: Global Point Liability Metrics
        $totalSystemPoints = \App\Models\User::sum(DB::raw('paid_points + bonus_points'));
        $withdrawablePoints = \App\Models\User::where('role', 'provider')->sum(DB::raw('paid_points + bonus_points'));

        return [
            'totalInflow' => (float)$totalInflow,
            'pointsRevenue' => (float)$pointsRevenue,
            'verificationRevenue' => (float)$verificationRevenue,
            'paidCommissions' => (float)$paidCommissions,
            'totalOutflow' => (float)$totalOutflow,
            'accruedCommissions' => (float)$accruedCommissions,
            'totalProfit' => (float)($paidCommissions + $verificationRevenue),
            'totalSystemPoints' => (float)$totalSystemPoints,
            'withdrawablePoints' => (float)$withdrawablePoints,
        ];
    }

    /**
     * Export the financial report to a CSV file (Excel compatible).
     */
    public function exportExcel(Request $request)
    {
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date'))->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date'))->endOfDay() : Carbon::now()->endOfDay();

        $metrics = $this->getFinancialMetrics($fromDate, $toDate);
        
        $filename = "Financial_Report_" . $fromDate->format('Y-m-d') . "_to_" . $toDate->format('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($fromDate, $toDate, $metrics) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 Arabic support in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // --- Section 1: Header ---
            fputcsv($file, [__('التقرير المالي العام')]);
            fputcsv($file, [__('الفترة من'), $fromDate->format('Y-m-d'), __('إلى'), $toDate->format('Y-m-d')]);
            fputcsv($file, []); // Empty line

            // --- Section 2: Summary Metrics ---
            fputcsv($file, [__('ملخص المؤشرات المالية')]);
            fputcsv($file, [__('المؤشر'), __('القيمة (ر.ي)')]);
            fputcsv($file, [__('إجمالي التدفقات الداخلة'), number_format($metrics['totalInflow'], 2)]);
            fputcsv($file, [__('إيرادات بيع النقاط'), number_format($metrics['pointsRevenue'], 2)]);
            fputcsv($file, [__('إيرادات باقات التوثيق'), number_format($metrics['verificationRevenue'], 2)]);
            fputcsv($file, [__('العمولات المحصلة'), number_format($metrics['paidCommissions'], 2)]);
            fputcsv($file, [__('العمولات المستحقة (غير المحصلة)'), number_format($metrics['accruedCommissions'], 2)]);
            fputcsv($file, [__('إجمالي التدفقات الخارجة (سحوبات)'), number_format($metrics['totalOutflow'], 2)]);
            fputcsv($file, [__('إجمالي الربح الصافي'), number_format($metrics['totalProfit'], 2)]);
            fputcsv($file, [__('إجمالي الالتزامات (نقاط في النظام)'), number_format($metrics['totalSystemPoints'], 2)]);
            fputcsv($file, []); // Empty line

            // --- Section 3: Points Sales Detail ---
            fputcsv($file, [__('تفاصيل مبيعات باقات النقاط')]);
            fputcsv($file, [__('التاريخ'), __('المستخدم'), __('الباقة'), __('المبلغ')]);
            $detailedPoints = UserPointsPackage::where('status', 'approved')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->with(['user', 'package'])->get();
            foreach ($detailedPoints as $p) {
                fputcsv($file, [$p->created_at->format('Y-m-d H:i'), $p->user->name ?? 'N/A', $p->package->name ?? 'N/A', $p->package->price ?? 0]);
            }
            fputcsv($file, []);

            // --- Section 4: Verifications Detail ---
            fputcsv($file, [__('تفاصيل إيرادات التوثيق')]);
            fputcsv($file, [__('التاريخ'), __('المستخدم'), __('نوع الباقة'), __('المبلغ')]);
            $detailedVerifications = UserVerificationPackages::where('status', 'approved')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->with(['user', 'verificationPackage'])->get();
            foreach ($detailedVerifications as $v) {
                fputcsv($file, [$v->created_at->format('Y-m-d H:i'), $v->user->name ?? 'N/A', $v->verificationPackage->name ?? 'N/A', $v->verificationPackage->price ?? 0]);
            }
            fputcsv($file, []);

            // --- Section 5: Withdrawals Detail ---
            fputcsv($file, [__('تفاصيل طلبات السحب المعتمدة')]);
            fputcsv($file, [__('التاريخ'), __('المستخدم'), __('المسؤول'), __('المبلغ')]);
            $detailedWithdrawals = WithdrawRequest::where('status', 'approved')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->with(['user', 'admin'])->get();
            foreach ($detailedWithdrawals as $w) {
                fputcsv($file, [$w->created_at->format('Y-m-d H:i'), $w->user->name ?? 'N/A', $w->admin->name ?? 'Admin', $w->amount]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
