<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    use AuthorizesRequests;

    public function dashboard(Request $request)
    {
        $this->authorize('viewDashboard', User::class);
        
        $filter = $request->get('filter', 'all'); // all, today, week, month
        $dateLimit = match($filter) {
            'today' => now()->startOfDay(),
            'week' => now()->subDays(7),
            'month' => now()->subDays(30),
            default => null,
        };

        // 1. Basic & User Stats
        $usersCount = User::count();
        $seekersCount = User::where('role', 'seeker')->count();
        $providersCount = User::where('role', 'provider')->count();
        
        // 2. Request & Financial Stats
        $requestQuery = \App\Models\Request::query();
        if ($dateLimit) $requestQuery->where('created_at', '>=', $dateLimit);
        
        $requestsCount = $requestQuery->count();
        $commissionsTotal = $requestQuery->sum('commission_amount');
        
        // 3. Pending Tasks (Critical)
        $pendingWithdrawalsCount = \App\Models\WithdrawRequest::where('status', 'pending')->count();
        $pendingComplaintsCount = \App\Models\RequestComplaint::where('status', 'pending')->count();
        $pendingVerificationPlans = \DB::table('user_verification_packages')->where('status', 'pending')->count();

        // 4. Revenue Mix (Meeting vs Custom vs Regular)
        // Corrected to avoid commission multiplication by joining
        $revenueMix = \DB::table('requests')
            ->join('request_service', function($join) {
                $join->on('requests.id', '=', 'request_service.request_id')
                     ->where('request_service.is_main', true); // Only link to main service type for stats
            })
            ->join('services', 'request_service.service_id', '=', 'services.id')
            ->select('services.type', \DB::raw('SUM(requests.commission_amount) as total'))
            ->groupBy('services.type')
            ->get();

        // 5. Top Performing Providers (Top 5 by Commission)
        $topProviders = User::where('role', 'provider')
            ->leftJoin('services', 'users.id', '=', 'services.provider_id')
            ->leftJoin('request_service', 'services.id', '=', 'request_service.service_id')
            ->leftJoin('requests', 'request_service.request_id', '=', 'requests.id')
            ->select(
                'users.id', 
                'users.name', 
                \DB::raw('COUNT(DISTINCT requests.id) as orders_count'),
                \DB::raw('SUM(DISTINCT CASE WHEN requests.id IS NOT NULL THEN requests.commission_amount ELSE 0 END) as total_commission')
            )
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_commission')
            ->limit(5)
            ->get();

        // 6. Comparative Analytics (Growth %)
        $thisMonthStart = now()->startOfMonth();
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $thisMonthRevenue = \App\Models\Request::where('created_at', '>=', $thisMonthStart)->sum('commission_amount');
        $lastMonthRevenue = \App\Models\Request::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('commission_amount');
        $revenueGrowth = $lastMonthRevenue > 0 ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 100;

        $thisMonthUsers = User::where('created_at', '>=', $thisMonthStart)->count();
        $lastMonthUsers = User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $userGrowth = $lastMonthUsers > 0 ? (($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100 : 100;

        // 7. Geographic Heatmap Data (Requests)
        $heatmapData = \App\Models\Request::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->limit(500)
            ->get(['latitude', 'longitude'])
            ->map(fn($r) => [$r->latitude, $r->longitude])
            ->values();

        // 8. Provider Locations (Markers)
        $providerLocations = User::where('role', 'provider')
            ->whereHas('profile', function($q) {
                $q->whereNotNull('latitude')->whereNotNull('longitude');
            })
            ->with(['profile'])
            ->get()
            ->map(fn($u) => [
                'name' => $u->name,
                'lat'  => $u->profile->latitude,
                'lng'  => $u->profile->longitude,
            ])
            ->values();

        // 9. Recent Reviews for Moderation
        $recentReviews = \App\Models\Review::with(['request.user', 'request.services'])->latest()->limit(3)->get();

        // 9. Revenue Chart Data (Last 6 Months)
        $monthlyRevenueLabels = [];
        $monthlyRevenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyRevenueLabels[] = $date->translatedFormat('F');
            $monthlyRevenueData[] = \App\Models\Request::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('commission_amount');
        }

        // 10. Recent Activity Feed
        $recentRequests = \App\Models\Request::with('user')->latest()->limit(5)->get();
        $newUsers = User::latest()->limit(5)->get();

        return view('dashboard', [
            'usersCount' => $usersCount,
            'seekersCount' => $seekersCount,
            'providersCount' => $providersCount,
            'requestsCount' => $requestsCount,
            'commissionsTotal' => $commissionsTotal,
            'pendingWithdrawalsCount' => $pendingWithdrawalsCount,
            'pendingComplaintsCount' => $pendingComplaintsCount,
            'pendingWebVerifications' => $pendingVerificationPlans,
            'revenueMix' => $revenueMix,
            'topProviders' => $topProviders,
            'revenueLabels' => $monthlyRevenueLabels,
            'revenueData' => $monthlyRevenueData,
            'recentRequests' => $recentRequests,
            'newUsers' => $newUsers,
            'filter' => $filter,
            'revenueGrowth' => $revenueGrowth,
            'userGrowth' => $userGrowth,
            'heatmapData' => $heatmapData,
            'providerLocations' => $providerLocations,
            'recentReviews' => $recentReviews
        ]);
    }
}
