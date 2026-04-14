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
        $pendingSystemComplaintsCount = \App\Models\SystemComplaint::where('status', 'pending')->count();
        $pendingVerificationPlans = \DB::table('user_verification_packages')->where('status', 'pending')->count();

        // 4. Revenue Mix (Services vs Verifications vs Points) - respect filters
        $servicesRevenue = \App\Models\Request::query();
        if ($dateLimit) $servicesRevenue->where('created_at', '>=', $dateLimit);
        $totalServices = $servicesRevenue->sum('commission_amount');

        $verificationRevenue = \DB::table('user_verification_packages')
            ->join('verification_packages', 'user_verification_packages.verification_package_id', '=', 'verification_packages.id')
            ->where('user_verification_packages.status', 'approved');
        if ($dateLimit) $verificationRevenue->where('user_verification_packages.created_at', '>=', $dateLimit);
        $totalVerifications = $verificationRevenue->sum('verification_packages.price');

        $pointsRevenue = \DB::table('user_points_packages')
            ->join('points_packages', 'user_points_packages.package_id', '=', 'points_packages.id')
            ->where('user_points_packages.status', 'approved');
        if ($dateLimit) $pointsRevenue->where('user_points_packages.created_at', '>=', $dateLimit);
        $totalPoints = $pointsRevenue->sum('points_packages.price');

        $revenueMix = collect([
            (object)['type' => __('الخدمات'), 'total' => (float)$totalServices],
            (object)['type' => __('باقات التوثيق'), 'total' => (float)$totalVerifications],
            (object)['type' => __('باقات النقاط'), 'total' => (float)$totalPoints],
        ]);

        $commissionsTotal = $totalServices + $totalVerifications + $totalPoints;

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

        $thisMonthRevenue = \App\Models\Request::where('created_at', '>=', $thisMonthStart)->sum('commission_amount') + 
                            \DB::table('user_verification_packages')
                                ->join('verification_packages', 'user_verification_packages.verification_package_id', '=', 'verification_packages.id')
                                ->where('user_verification_packages.status', 'approved')
                                ->where('user_verification_packages.created_at', '>=', $thisMonthStart)
                                ->sum('verification_packages.price') +
                            \DB::table('user_points_packages')
                                ->join('points_packages', 'user_points_packages.package_id', '=', 'points_packages.id')
                                ->where('user_points_packages.status', 'approved')
                                ->where('user_points_packages.created_at', '>=', $thisMonthStart)
                                ->sum('points_packages.price');

        $lastMonthRevenue = \App\Models\Request::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('commission_amount') +
                            \DB::table('user_verification_packages')
                                ->join('verification_packages', 'user_verification_packages.verification_package_id', '=', 'verification_packages.id')
                                ->where('user_verification_packages.status', 'approved')
                                ->whereBetween('user_verification_packages.created_at', [$lastMonthStart, $lastMonthEnd])
                                ->sum('verification_packages.price') +
                            \DB::table('user_points_packages')
                                ->join('points_packages', 'user_points_packages.package_id', '=', 'points_packages.id')
                                ->where('user_points_packages.status', 'approved')
                                ->whereBetween('user_points_packages.created_at', [$lastMonthStart, $lastMonthEnd])
                                ->sum('points_packages.price');
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
            
            $servicesSum = \App\Models\Request::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('commission_amount');
                
            $verificationsSum = \DB::table('user_verification_packages')
                ->join('verification_packages', 'user_verification_packages.verification_package_id', '=', 'verification_packages.id')
                ->where('user_verification_packages.status', 'approved')
                ->whereYear('user_verification_packages.created_at', $date->year)
                ->whereMonth('user_verification_packages.created_at', $date->month)
                ->sum('verification_packages.price');
                
            $pointsSum = \DB::table('user_points_packages')
                ->join('points_packages', 'user_points_packages.package_id', '=', 'points_packages.id')
                ->where('user_points_packages.status', 'approved')
                ->whereYear('user_points_packages.created_at', $date->year)
                ->whereMonth('user_points_packages.created_at', $date->month)
                ->sum('points_packages.price');

            $monthlyRevenueData[] = $servicesSum + $verificationsSum + $pointsSum;
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
            'pendingSystemComplaintsCount' => $pendingSystemComplaintsCount,
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
