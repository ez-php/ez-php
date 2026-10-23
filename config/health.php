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
    // One disk-space probe per path (e.g. the storage directory); empty = none.
    // DEGRADED below degraded_percent free, UNHEALTHY below unhealthy_percent free.
    'disk' => [
        'paths' => array_values(array_filter(explode(',', getenv('HEALTH_DISK_PATHS') ?: ''))),
        'degraded_percent' => (float) (getenv('HEALTH_DISK_DEGRADED_PERCENT') ?: 10),
        'unhealthy_percent' => (float) (getenv('HEALTH_DISK_UNHEALTHY_PERCENT') ?: 5),
    ],
    // Raw exception messages of failing probes in the public /health JSON (PDO user/host,
    // internal URLs). Unset: follow app.debug; failing probes then read "Check failed".
    'expose_messages' => getenv('HEALTH_EXPOSE_MESSAGES') === false || getenv('HEALTH_EXPOSE_MESSAGES') === ''
        ? null
        : filter_var(getenv('HEALTH_EXPOSE_MESSAGES'), FILTER_VALIDATE_BOOLEAN),
];
