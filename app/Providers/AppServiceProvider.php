<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });

        // Global view sharing for Sidebar Badges (Admin)
        \Illuminate\Support\Facades\View::composer('partials.admin.sidebar', function ($view) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                $view->with([
                    'pending_withdrawals_count' => \App\Models\WithdrawRequest::where('status', 'pending')->count(),
                    'pending_complaints_count' => \App\Models\RequestComplaint::where('status', 'pending')->count(),
                    'pending_system_complaints_count' => \App\Models\SystemComplaint::where('status', \App\constant\SystemComplaintStatus::PENDING)->count(),
                    'pending_provider_requests_count' => \App\Models\ProviderRequest::where('status', 'pending')->count(),
                    'pending_user_points_packages_count' => \App\Models\UserPointsPackage::where('status', 'pending')->count(),
                    'pending_commission_bonds_count' => \App\Models\RequestCommissionBond::where('status', 'pending')->count(),
                    'pending_verifications_count' => \DB::table('user_verification_packages')->where('status', 'pending')->count(),
                    'pending_id_verifications_count' => \App\Models\VerificationRequest::where('status', 'pending')->count(),
                ]);
            }
        });
    }
}
