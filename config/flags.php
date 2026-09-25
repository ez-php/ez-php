<?php

declare(strict_types=1);

/*
 * The `file` driver reads the flag definitions from the file named by `file`.
 * That file must NOT live in `config/`: ConfigLoader globs `config/*.php` and
 * keys each one by its basename, so a definitions file at `config/flags.php`
 * would be this very file — the driver would then read `driver` and `file` as
 * flag names (both truthy) and every real flag would be missing.
 */

return [
    'driver' => getenv('FLAGS_DRIVER') ?: 'file',
    'file' => getenv('FLAGS_FILE') ?: 'flags.php',
    // driver = redis
    'redis' => [
        'host' => getenv('FLAGS_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('FLAGS_REDIS_PORT') ?: 6379),
        'database' => (int) (getenv('FLAGS_REDIS_DB') ?: 0),
    ],

    /*
     * Percentage rollouts: flag name => 0–100. `Flag::enabledFor($name, $userId)` is then
     * true for a stable slice of users (crc32-bucketed); the value replaces the stored
     * flag for that name. Example: 'new-checkout' => 25
     */
    'rollouts' => [],
];
