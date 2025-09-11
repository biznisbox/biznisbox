<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (isAppInstalled()) {
            return api_response(
                [
                    'message' => __('responses.app_installed'),
                    'status' => 'error',
                ],
                __('responses.app_installed'),
                400,
            );
        }
        return $next($request);
    }
}
