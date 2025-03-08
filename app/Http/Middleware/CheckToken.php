<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelpers\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type)
    {
        $authType = auth('api')->payload()->get('type');
        if ($type == $authType) {
            return $next($request);
        }

        return (new Response)->error(message: "UNAUTHORIZED", status: Response::HTTP_UNAUTHORIZED);
    }
}
