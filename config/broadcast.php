<?php

declare(strict_types=1);

return [
    'driver' => getenv('BROADCAST_DRIVER') ?: 'null',
    'log_path' => getenv('BROADCAST_LOG_PATH') ?: '',
    'redis' => [
        'host' => getenv('BROADCAST_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('BROADCAST_REDIS_PORT') ?: 6379),
        'database' => (int) (getenv('BROADCAST_REDIS_DB') ?: 0),
    ],
];
