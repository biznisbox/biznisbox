<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = user_data();

        if (!$user) {
            return api_response(null, 'Unauthorized', 401);
        }

        $user_permissions = $user->data->permissions;

        $permissions = is_array($permission) ? $permission : explode('|', $permission);

        foreach ($permissions as $permission) {
            if (!in_array($permission, $user_permissions)) {
                return api_response(null, 'Forbidden', 403);
            }
        }
        return $next($request);
    }
}
