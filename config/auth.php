<?php

declare(strict_types=1);

return [
    // JwtServiceProvider (ez-php/auth). The secret must be at least 32 bytes,
    // e.g. bin2hex(random_bytes(32)); resolving JwtManager throws otherwise.
    'jwt' => [
        'secret' => getenv('JWT_SECRET') ?: '',
        'ttl' => (int) (getenv('JWT_TTL') ?: 3600),
    ],
];
