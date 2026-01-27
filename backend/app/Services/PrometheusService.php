<?php

namespace App\Services;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis as PrometheusRedis;

class PrometheusService
{
    public static function registry(): CollectorRegistry
    {
        PrometheusRedis::setDefaultOptions([
            'host' => env('REDIS_HOST', 'redis'),
            'port' => env('REDIS_PORT', 6379),
            'password' => env('REDIS_PASSWORD'),
            'database' => env('REDIS_DB', 0),
            'prefix' => 'prometheus:',
        ]);

        return new CollectorRegistry(new PrometheusRedis());
    }
}
