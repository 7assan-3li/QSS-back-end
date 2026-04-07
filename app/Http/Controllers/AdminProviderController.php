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
        $query = User::where('role', Role::PROVIDER)
            ->with(['profile', 'services']);

        // Simple Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $providers = $query->latest()->paginate(12);

        return view('admin.providers.index', compact('providers'));
    }

    /**
     * Display the specified service provider details.
     */
    public function show($id)
    {
        $provider = User::where('role', Role::PROVIDER)
            ->with(['profile.profilePhones', 'profile.previousWorks', 'services.category', 'banks'])
            ->findOrFail($id);

        // Stats
        $stats = [
            'total_requests' => RequestModel::whereHas('main_service', function($q) use ($id) {
                $q->where('provider_id', $id);
            })->count(),
            
            'completed_requests' => RequestModel::whereHas('main_service', function($q) use ($id) {
                $q->where('provider_id', $id);
            })->where('status', RequestStatus::COMPLETED)->count(),
            
            'total_commissions' => RequestModel::whereHas('main_service', function($q) use ($id) {
                $q->where('provider_id', $id);
            })->sum('commission_amount'),
            
            'services_count' => $provider->services()->count(),
        ];

        // Recent Requests
        $requests = RequestModel::whereHas('main_service', function($q) use ($id) {
                $q->where('provider_id', $id);
            })
            ->with(['user', 'main_service'])
            ->latest()
            ->paginate(10, ['*'], 'requests_page');

        return view('admin.providers.show', compact('provider', 'stats', 'requests'));
    }
}
