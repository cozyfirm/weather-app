<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
        $token = $request->header('api_token')
            ?? $request->bearerToken()
            ?? $request->input('api_token')
            ?? $request->header('X-Api-Token');

        if(isset($token) and $token == env('api_token')){
            return $next($request);
        }else{
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->guest(route('auth'));
        }
    }
}
