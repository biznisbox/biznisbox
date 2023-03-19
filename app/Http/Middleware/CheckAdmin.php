<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
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
        $token = $request->bearerToken();
        if ($token) {
            $user_permissions = user_data()->data->permissions;
            if (in_array('admin', $user_permissions)) {
                return $next($request);
            }
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json(['message' => __('response.auth.failed')], 401);
    }
}
