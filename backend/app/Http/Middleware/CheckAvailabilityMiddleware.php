<?php

namespace App\Http\Middleware;

use App\Helpers\Auth;
use App\Services\RedisService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAvailabilityMiddleware
{
    private RedisService $redisService;
    public function __construct(RedisService $redisService){
        $this->redisService = $redisService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isBlocked = $this->redisService->get($request->url());
        if (!$isBlocked || Auth::user()->id == $isBlocked){
            $this->redisService->set($request->url(), Auth::user()->id, env('BLOCK_PAGE_TIME') * 60);
            return $next($request);
        }
        return response()->json([
            'success' => false,
        ], 403);
    }
}
