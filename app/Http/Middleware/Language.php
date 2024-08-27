<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale') && !empty(config('languages')[session()->get('locale')])) {
            app()->setLocale(session()->get('locale'));
        } else {
            app()->setLocale(config('app.fallback_locale'));
        }

        return $next($request);
    }
}
