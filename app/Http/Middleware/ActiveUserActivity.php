<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Pastikan tipe Response dari Illuminate
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ActiveUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->userSetting && auth()->user()->userSetting->entity) {
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put(
                "online-users-" . auth()->user()->id,
                auth()->user(),
                $expiresAt
            );
        }

        return $next($request);
    }
}
