<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user && $user->role === 'user') {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized (User Only)'], 403);
    }
}
