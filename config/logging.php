<?php

declare(strict_types=1);

return [
    /*
     * Log driver: file | stdout | null | json | stack
     *
     * file   — daily-rotated files in LOG_PATH; best for production
     * stdout — echo to stdout (info/warning/debug) / stderr (error/critical)
     * null   — discard all entries (useful in tests)
     * json   — serialise each entry as JSON and forward to LOG_JSON_INNER
     * stack  — fan out to multiple drivers simultaneously (configure below)
     */
    'driver' => getenv('LOG_DRIVER') ?: 'file',

    /*
     * Directory for the file driver.
     * Defaults to storage/logs inside the application root when empty.
     */
    'path' => getenv('LOG_PATH') ?: '',

    /*
     * Maximum file size in bytes before the log file is rotated.
     * 0 = no size limit (rotation is still date-based via the filename).
     */
    'max_bytes' => (int) (getenv('LOG_MAX_BYTES') ?: 0),

    /*
     * Minimum log level to write. Entries below this level are silently dropped.
     * Accepted values: debug | info | warning | error | critical
     * Empty string = accept all levels.
     */
    'min_level' => getenv('LOG_LEVEL') ?: '',

    /*
     * Inner driver used when LOG_DRIVER=json.
     * The JSON driver serialises the entry and forwards it to this driver.
     * Accepted values: file | stdout | null
     */
    'json_inner' => getenv('LOG_JSON_INNER') ?: 'stdout',

    /*
     * Drivers loaded when LOG_DRIVER=stack.
     * Each entry is a driver name (file, stdout, null).
     * Not configurable via env — edit this array directly for stack setups.
     */
    'stack' => ['file', 'stdout'],
];
