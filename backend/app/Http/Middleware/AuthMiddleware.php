<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use App\Services\VisitService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    private VisitService $visitService;
    public function __construct(
        VisitService $visitService
    )
    {
        $this->visitService = $visitService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->visitService->create();
        if(Auth::check()){
            return $next($request);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
    }
}
