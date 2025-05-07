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
        } elseif ($request->has('lang')) {
            app()->setLocale($request->input('lang'));
        } elseif ($request->hasCookie('lang')) {
            app()->setLocale($request->cookie('lang'));
        } else {
            try {
                app()->setLocale(settings('default_lang'));
            } catch (\Exception $e) {
                app()->setLocale('en');
            }
        }

        return $next($request);
    }
}
