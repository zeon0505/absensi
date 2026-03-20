<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastActiveAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Update last_active_at only if it's been more than 1 minute since last update to avoid excessive DB writes
            $user = Auth::user();
            if (!$user->last_active_at || Carbon::parse($user->last_active_at)->diffInMinutes(Carbon::now()) >= 1) {
                $user->update([
                    'last_active_at' => Carbon::now(),
                ]);
            }
        }

        return $next($request);
    }
}
