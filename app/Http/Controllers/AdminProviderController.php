<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Request as RequestModel;
use App\constant\Role;
use App\constant\RequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProviderController extends Controller
{
    /**
     * Display a listing of service providers.
     */
    public function index(Request $request)
    {
        $query = $this->buildProviderQuery($request);
        $providers = $query->latest()->paginate(12);

        return view('admin.providers.index', compact('providers'));
    }

    /**
     * Export detailed provider data to CSV.
     */
    public function exportDetailed(Request $request)
    {
        $providers = $this->buildProviderQuery($request)->get();
        
        $filename = "qss_detailed_providers_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            __('الاسم'), 
            __('البريد الإلكتروني'), 
            __('المسمى الوظيفي'), 
            __('عدد الخدمات'), 
            __('إجمالي الطلبات'), 
            __('إجمالي العمولات'), 
            __('حالة التوثيق'), 
            __('تاريخ الانضمام')
        ];

        $callback = function() use($providers, $columns) {
            $file = fopen('php://output', 'w');
            // Adding BOM for Arabic support in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($providers as $p) {
                $isVerified = $p->provider_verified_until && \Carbon\Carbon::parse($p->provider_verified_until)->isFuture();
                
                // Detailed Stats
                $totalRequests = RequestModel::whereHas('main_service', fn($q) => $q->where('provider_id', $p->id))->count();
                $totalCommissions = RequestModel::whereHas('main_service', fn($q) => $q->where('provider_id', $p->id))->sum('commission_amount');

                fputcsv($file, [
                    $p->name,
                    $p->email,
                    $p->profile->job_title ?? '---',
                    $p->services->count(),
                    $totalRequests,
                    number_format($totalCommissions, 2) . ' YER',
                    $isVerified ? __('موثق') : __('غير موثق'),
                    $p->created_at->format('Y-m-d')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Build the provider query based on request filters.
     */
    private function buildProviderQuery(Request $request)
    {
        $query = User::where('role', Role::PROVIDER)->with(['profile', 'services']);

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Status Filter
        if ($request->status) {
            if ($request->status === 'verified') {
                $query->whereNotNull('provider_verified_until')->where('provider_verified_until', '>=', now());
            } elseif ($request->status === 'unverified') {
                $query->where(function($q) {
                    $q->whereNull('provider_verified_until')->orWhere('provider_verified_until', '<', now());
                });
            }
        }

        // Date Range Filter
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        return $query;
    }

    /**
     * Display the specified service provider.
     */
    public function show($id)
    {
        $provider = User::with([
            'profile.previousWorks', 
            'profile.profilePhones', 
            'services.category', 
            'banks',
            'verificationPackages'
        ])->where('role', Role::PROVIDER)->findOrFail($id);

        // Fetch Requests for this provider
        $requestsQuery = RequestModel::whereHas('main_service', function($q) use ($provider) {
            $q->where('provider_id', $provider->id);
        })->with(['user', 'main_service', 'review']);

        // Stats
        $stats = [
            'total_requests' => (clone $requestsQuery)->count(),
            'completed_requests' => (clone $requestsQuery)->where('status', RequestStatus::COMPLETED)->count(),
            'total_commissions' => (clone $requestsQuery)->sum('commission_amount'),
            'total_revenue' => (clone $requestsQuery)->sum('total_price'),
            'services_count' => $provider->services->count(),
            'avg_rating' => (clone $requestsQuery)->whereHas('review')->get()->avg('review.rating') ?? 0,
        ];

        // Paginated Requests
        $requests = $requestsQuery->latest()->paginate(10);

        return view('admin.providers.show', compact('provider', 'stats', 'requests'));
    }
}
