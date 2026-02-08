<?php

namespace App\Http\Middleware;

use App\Services\TechWorkService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TechWorkMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    private TechWorkService $techWorkService;
    public function __construct(
        TechWorkService $techWorkService
    )
    {
        $this->techWorkService = $techWorkService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        if($this->techWorkService->isTechWork()) {
            return response()->json([
                'error' => 'Tech work',
                'success' => false,
            ], 403);
        }
        return $next($request);
    }
}
