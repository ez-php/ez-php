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
    // Reject session ids the client chose (session fixation); keep on.
    'strict_mode' => filter_var(getenv('SESSION_STRICT_MODE') ?: 'true', FILTER_VALIDATE_BOOLEAN),
    'cookie' => [
        'name' => getenv('SESSION_COOKIE') ?: '',
        // null = auto: Secure on HTTPS requests. Set true when TLS terminates at a proxy.
        'secure' => getenv('SESSION_SECURE_COOKIE') === false || getenv('SESSION_SECURE_COOKIE') === ''
            ? null
            : filter_var(getenv('SESSION_SECURE_COOKIE'), FILTER_VALIDATE_BOOLEAN),
        'httponly' => filter_var(getenv('SESSION_HTTP_ONLY') ?: 'true', FILTER_VALIDATE_BOOLEAN),
        'samesite' => getenv('SESSION_SAME_SITE') ?: 'Lax',
        'lifetime' => (int) (getenv('SESSION_LIFETIME') ?: 0),
        'path' => getenv('SESSION_PATH') ?: '/',
        'domain' => getenv('SESSION_DOMAIN') ?: '',
    ],
];
