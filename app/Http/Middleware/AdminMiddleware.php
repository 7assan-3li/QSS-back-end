<?php

namespace App\Http\Middleware;

use App\constant\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login')
                ->with('error', 'يرجى تسجيل الدخول للمتابعة');
        }
        $allowedRoles = [Role::ADMIN, Role::EMPLOYEE];

        if (! in_array($user->role, $allowedRoles)) {
            // دعم API
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'عذرًا، لا تمتلك الصلاحيات الإدارية المطلوبة'
                ], 403);
            }


            // Redirect للمستخدم العادي
            auth()->logout();
            return redirect()->route('dashboard')
                ->with('error', 'عذرًا، لا تمتلك الصلاحيات الإدارية المطلوبة');
        }




        return $next($request);
    }
}
