<?php

declare(strict_types=1);

return [
    'driver' => getenv('SESSION_DRIVER') ?: 'file',
    'file' => [
        'path' => getenv('SESSION_FILE_PATH') ?: sys_get_temp_dir() . '/ez-session',
    ],
    'database' => [
        'table' => getenv('SESSION_TABLE') ?: 'sessions',
    ],
    'redis' => [
        'host' => getenv('SESSION_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('SESSION_REDIS_PORT') ?: 6379),
        'database' => (int) (getenv('SESSION_REDIS_DATABASE') ?: 0),
        'ttl' => (int) (getenv('SESSION_REDIS_TTL') ?: 1440),
    ],
    // 0 disables periodic session-id regeneration.
    'regenerate_interval' => (int) (getenv('SESSION_REGENERATE_INTERVAL') ?: 0),
];
