<?php

declare(strict_types=1);

return [
    // Absolute path for the generated preload script (reference it from
    // php.ini: opcache.preload=<this file>).
    'output_file' => getenv('OPCACHE_PRELOAD_FILE') ?: dirname(__DIR__) . '/preload.php',

    // Directories scanned for PHP files to preload.
    'paths' => [
        dirname(__DIR__) . '/vendor/ez-php/framework/src',
        dirname(__DIR__) . '/vendor/ez-php/contracts/src',
        dirname(__DIR__) . '/app',
    ],

    // Filename glob patterns to exclude.
    'exclude' => [
        '*Test.php',
        '*TestCase.php',
        '*Interface.php',
    ],

    // true: emit require_once instead of opcache_compile_file().
    'require_once' => false,
];
