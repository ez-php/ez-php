<?php

declare(strict_types=1);

return [
    'redis' => [
        'host' => getenv('REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('REDIS_PORT') ?: 6379),
    ],
    'opcache' => [
        // Adds an OPcache probe (memory/interned-string/key usage) to /health.
        'enabled' => filter_var(getenv('HEALTH_OPCACHE_ENABLED'), FILTER_VALIDATE_BOOLEAN),
    ],
];
