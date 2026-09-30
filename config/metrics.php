<?php

declare(strict_types=1);

return [
    // Path of the GET route serving the Prometheus text format. Set
    // METRICS_ENDPOINT= (empty) to skip auto-registration and register
    // MetricsController yourself behind your own middleware.
    'endpoint' => getenv('METRICS_ENDPOINT') !== false ? getenv('METRICS_ENDPOINT') : '/metrics',
    // Where values live: memory (per process — resets every request under PHP-FPM),
    // apcu (shared by the workers of one host; needs ext-apcu) or redis (shared across hosts).
    'storage' => getenv('METRICS_STORAGE') ?: 'memory',
    'prefix' => getenv('METRICS_PREFIX') ?: 'ez-php:metrics:',
    'redis' => [
        'host' => getenv('METRICS_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('METRICS_REDIS_PORT') ?: 6379),
        'database' => (int) (getenv('METRICS_REDIS_DB') ?: 0),
    ],
];
