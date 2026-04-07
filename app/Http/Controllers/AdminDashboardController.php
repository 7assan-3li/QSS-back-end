<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    use AuthorizesRequests;

    public function dashboard()
    {
        $this->authorize('viewDashboard', User::class);
        
        // Basic Stats
        $usersCount = User::count();
        $categoriesCount = Category::count();
        $requestsCount = \App\Models\Request::count();
        $commissionsTotal = \App\Models\Request::sum('commission_amount');

        // Revenue Chart Data (Last 6 Months)
        $monthlyRevenueLabels = [];
        $monthlyRevenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyRevenueLabels[] = $date->translatedFormat('F');
            $monthlyRevenueData[] = \App\Models\Request::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('commission_amount');
        }

        return view('dashboard', [
            'usersCount' => $usersCount,
            'categoriesCount' => $categoriesCount,
            'requestsCount' => $requestsCount,
            'commissionsTotal' => $commissionsTotal,
            'revenueLabels' => $monthlyRevenueLabels,
            'revenueData' => $monthlyRevenueData,
        ]);
    }
}
