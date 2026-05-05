<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->status === 'suspended') {
            $message = 'عذراً، لقد تم إيقاف حسابك من قبل الإدارة. يرجى التواصل مع الدعم الفني.';
            
            if ($request->expectsJson()) {
                auth()->user()->tokens()->delete();
                return response()->json(['message' => $message], 403);
            }

            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        return $next($request);
    }
}
