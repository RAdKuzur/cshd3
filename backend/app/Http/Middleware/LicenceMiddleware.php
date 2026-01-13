<?php

namespace App\Http\Middleware;

use App\Services\LicenceService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LicenceMiddleware
{
    private LicenceService $licenceService;
    public function __construct(
        LicenceService $licenceService
    )
    {
        $this->licenceService = $licenceService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->licenceService->check()) {
            return $next($request);
        }
        else {
            return response()->json(
                ['error' => 'Licence error'],
            403);
        }

    }
}
