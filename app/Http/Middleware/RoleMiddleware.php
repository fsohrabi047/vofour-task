<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request 
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next 
     * @param string $roleName 
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roleName)
    {
        abort_if(
            !in_array($request->user()->role, ['super-admin', $roleName]),
            Response::HTTP_FORBIDDEN,
            __('messages.have_not_permission')
        );

        return $next($request);
    }
}
