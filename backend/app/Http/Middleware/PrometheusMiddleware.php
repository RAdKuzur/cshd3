<?php

namespace App\Http\Middleware;

use App\Services\PrometheusService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrometheusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        $duration = microtime(true) - $start;

        $registry = PrometheusService::registry();

        $allRequestsCounter = $registry->getOrRegisterCounter(
            'app',
            'http_requests_all_total',
            'Total HTTP requests (all)'
        );
        $allRequestsCounter->inc();

        $counter = $registry->getOrRegisterCounter(
            'app',
            'http_requests_total',
            'Total HTTP requests',
            ['method', 'path', 'status']
        );

        $counter->inc([
            $request->method(),
            $request->route()?->uri() ?? 'unknown',
            $response->getStatusCode(),
        ]);

        $histogram = $registry->getOrRegisterHistogram(
            'app',
            'http_request_duration_seconds',
            'HTTP request duration',
            ['path'],
            [0.1, 0.3, 0.5, 1, 2, 5]
        );

        $histogram->observe($duration, [
            $request->route()?->uri() ?? 'unknown'
        ]);
        return $response;
    }
}
