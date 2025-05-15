<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthOrGuestUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = request()->header('Authorization');
        try {
            if (isset($token)) {
                JWTAuth::parseToken()->authenticate(request()->header('Authorization'));
            }
        } catch (TokenExpiredException $e) {
        } finally {
            return $next($request);
        }
    }
}
