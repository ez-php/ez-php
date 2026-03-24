<?php

declare(strict_types=1);

return [
    'driver' => getenv('QUEUE_DRIVER') ?: 'database',
    'redis' => [
        'host' => getenv('QUEUE_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('QUEUE_REDIS_PORT') ?: 6379),
        'database' => (int) (getenv('QUEUE_REDIS_DB') ?: 0),
    ],
];
