<?php

declare(strict_types=1);

return [
    // Overlap-prevention mutex for withoutOverlapping() entries:
    // file | database | database_expiry | redis | cache (ez-php/cache) | none
    'mutex' => getenv('SCHEDULER_MUTEX') ?: 'file',
    // Lock lifetime in seconds for database_expiry, redis and cache
    'ttl' => (int) (getenv('SCHEDULER_TTL') ?: 3600),
    'file' => [
        'path' => getenv('SCHEDULER_LOCK_PATH') ?: sys_get_temp_dir() . '/ez-scheduler-locks',
    ],
    'redis' => [
        'host' => getenv('SCHEDULER_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('SCHEDULER_REDIS_PORT') ?: 6379),
        'database' => (int) (getenv('SCHEDULER_REDIS_DB') ?: 0),
    ],
];
