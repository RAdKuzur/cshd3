<?php

namespace App\Http\Middleware;

use App\Helpers\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyUsernameMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->route('username');
        if (Auth::user()->username != $username) {
            return response()->json([
                'error' => 'Forbidden',
                'success' => false,
            ], 403);
        }
        return $next($request);
    }
}
