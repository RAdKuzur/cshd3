<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use App\Services\VisitService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckPermissionMiddleware
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
        $userId = Auth::user()->id;
        if($this->authService->hasAccess($userId, request()->route()->getName())) {
            return $next($request);
        }
        return response()->json([
            'success' => false,
        ], 403);
    }
}
