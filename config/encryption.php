<?php

declare(strict_types=1);

return [
    // Current key: "base64:" + 32 random bytes — generate with `ez encryption:key`.
    'key' => getenv('ENCRYPTION_KEY') ?: '',
    // Decrypt-only keys after a rotation, comma-separated.
    'previous_keys' => getenv('ENCRYPTION_PREVIOUS_KEYS') ?: '',
    // Cookies EncryptedCookieMiddleware leaves unencrypted (read by JavaScript).
    'cookie_except' => ['XSRF-TOKEN'],
];
