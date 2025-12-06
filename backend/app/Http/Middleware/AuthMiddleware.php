<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    private AuthService $authService;
    public function __construct(
        AuthService $authService
    )
    {
        $this->authService = $authService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = $request->cookie('access_token');
        $refreshToken = $request->cookie('refresh_token');
        if ($this->authService->isAuth($accessToken, $refreshToken)) {
            $tokens = $this->authService->refresh($refreshToken);
            return $next($request)
                ->cookie('refresh_token', $tokens['refreshToken'], (int)env('REFRESH_TOKEN_TIME'))
                ->cookie('access_token', $tokens['accessToken'], (int)env('ACCESS_TOKEN_TIME'));
        }
        return response()->json([
            'success' => false,
        ], 401);

    }
}
