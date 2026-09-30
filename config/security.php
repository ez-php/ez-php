<?php

declare(strict_types=1);

return [
    // Overrides for SecurityHeadersMiddleware (register it with
    // $app->middleware(\EzPhp\Middleware\SecurityHeadersMiddleware::class)).
    // Defaults: X-Content-Type-Options: nosniff, X-Frame-Options: DENY,
    // Referrer-Policy: strict-origin-when-cross-origin,
    // Strict-Transport-Security: max-age=31536000; includeSubDomains.
    // A string sets or replaces a header, null removes one.
    'headers' => [
        // 'Content-Security-Policy' => "default-src 'self'",
        // 'Strict-Transport-Security' => null,
    ],
];
