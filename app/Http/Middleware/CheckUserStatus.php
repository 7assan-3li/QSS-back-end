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
        $user = auth()->user();

        if (auth()->check() && $user->status === 'suspended') {
            // السماح للآدمن والموظفين بالدخول حتى لو كان هناك مشكلة في الحالة (اختياري حسب رغبتك)
            // أو منع الجميع ما عدا الآدمن
            if (in_array($user->role, [\App\constant\Role::ADMIN, \App\constant\Role::EMPLOYEE])) {
                return $next($request);
            }

            $message = 'عذراً، لقد تم إيقاف حسابك من قبل الإدارة. يرجى التواصل مع الدعم الفني.';
            
            if ($request->expectsJson()) {
                $user->tokens()->delete();
                return response()->json(['message' => $message], 403);
            }

            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        return $next($request);
    }
}
