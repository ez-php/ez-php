<?php

declare(strict_types=1);

return [
    'driver' => getenv('RATE_LIMITER_DRIVER') ?: 'array',
    'redis' => [
        'host' => getenv('RATE_LIMITER_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('RATE_LIMITER_REDIS_PORT') ?: 6379),
        'database' => (int) (getenv('RATE_LIMITER_REDIS_DB') ?: 0),
    ],
];
