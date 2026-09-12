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
];
