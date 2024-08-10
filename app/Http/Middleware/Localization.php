<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Language');
        if ($locale) {
            app()->setLocale($locale);
        }

        if ($request->has('lang')) {
            app()->setLocale($request->input('lang'));
        }
        return $next($request);
    }
}
