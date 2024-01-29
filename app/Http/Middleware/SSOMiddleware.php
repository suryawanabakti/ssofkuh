<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SSOMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('username') === env('USERNAME_SSO') && $request->header('password') === env("SECRET_KEY_SSO")) {
            return $next($request);
        } else {
            return response()->json([
                'message' => 'Unathorized'
            ], 401);
        }
    }
}
