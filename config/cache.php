<?php

declare(strict_types=1);

return [
    // array | file | redis | memcached | database | apcu (ext-apcu; CLI needs apc.enable_cli=1)
    'driver' => getenv('CACHE_DRIVER') ?: 'array',
    'file_path' => getenv('CACHE_PATH') ?: sys_get_temp_dir() . '/ez-cache',
    // Non-empty: every key, lock and tag list is prefixed (stores shared between apps/tenants)
    'prefix' => getenv('CACHE_PREFIX') ?: '',
    'redis' => [
        'host' => getenv('CACHE_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('CACHE_REDIS_PORT') ?: 6379),
        'database' => (int) (getenv('CACHE_REDIS_DB') ?: 0),
    ],
    'memcached' => [
        'host' => getenv('CACHE_MEMCACHED_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('CACHE_MEMCACHED_PORT') ?: 11211),
        'weight' => (int) (getenv('CACHE_MEMCACHED_WEIGHT') ?: 0),
    ],
    // driver = database (tables are created automatically)
    'database' => [
        'table' => getenv('CACHE_DB_TABLE') ?: 'cache',
        'lock_table' => getenv('CACHE_DB_LOCK_TABLE') ?: 'cache_locks',
    ],
];
