<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Log;
 use Illuminate\Support\Facades\Auth;

class SyncSessionId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('SyncSessionId middleware HIT');

        $user = Auth::user();

        if (!$user) {
            Log::info('No authenticated user found');
            return $next($request);
        }

        Log::info('User ID: ' . $user->id);

        // ======================================
        // 1. SESSION CHECK
        // ======================================
        if ($user->session_id !== session()->getId()) {

            Log::warning('SESSION MISMATCH → logout');

            Auth::logout();
            session()->invalidate();

            return redirect('/');
        }

        // ======================================
        // 2. INACTIVITY CHECK (CHECK FIRST)
        // ======================================
        if (
            $user->last_active_at &&
            now()->diffInSeconds($user->last_active_at) > 300
        ) {

            Log::warning('USER INACTIVE → AUTO LOGOUT');

            $user->login_session_id = null;
            $user->save();

            Auth::logout();

            session()->invalidate();
            session()->regenerateToken();

            return redirect('/');
        }

        // ======================================
        // 3. UPDATE LAST ACTIVE (AFTER CHECK)
        // ======================================
        $user->last_active_at = now();
        $user->save();

        Log::info('Session OK → user allowed');

        return $next($request);
    }
}
