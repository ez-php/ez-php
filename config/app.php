<?php

declare(strict_types=1);

return [
    'name' => getenv('APP_NAME'),
    'debug' => filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN),
    'locale' => getenv('APP_LOCALE') ?: 'en',
    'fallback_locale' => getenv('APP_FALLBACK_LOCALE') ?: 'en',
    // Optional ordered fallback chain (e.g. ['de_AT', 'de', 'en']); overrides fallback_locale when set.
    'fallback_locales' => null,
    // Spec version reported by ez-php/openapi.
    'version' => getenv('APP_VERSION') ?: '1.0.0',
    'lang_path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lang',
];
