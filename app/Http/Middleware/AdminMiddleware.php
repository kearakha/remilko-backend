<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized (Admin Only)'], 403);
    }
}
