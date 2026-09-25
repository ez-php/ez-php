<?php

declare(strict_types=1);

return [
    // Redis probe connection. Own variables (like CACHE_REDIS_*), not REDIS_PORT:
    // in .env.example REDIS_PORT is the host-published port, while the probe
    // connects from inside the container.
    'redis' => [
        'host' => getenv('HEALTH_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('HEALTH_REDIS_PORT') ?: 6379),
    ],
    'opcache' => [
        // Adds an OPcache probe (memory/interned-string/key usage) to /health.
        'enabled' => filter_var(getenv('HEALTH_OPCACHE_ENABLED'), FILTER_VALIDATE_BOOLEAN),
    ],
];
