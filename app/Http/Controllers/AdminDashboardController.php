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
        return view('dashboard', [
            'usersCount' => User::count(),
            'categoriesCount' => Category::count(),
        ]);
    }
}
