<?php

declare(strict_types=1);

return [
    'secret' => getenv('WEBHOOK_SECRET') ?: '',
    'signature_header' => getenv('WEBHOOK_SIGNATURE_HEADER') ?: 'X-Webhook-Signature',
    'queue' => getenv('WEBHOOK_QUEUE') ?: 'default',
    // Replay protection, both opt-in: sender adds a signed timestamp, receiver enforces a tolerance window.
    'timestamped' => filter_var(getenv('WEBHOOK_TIMESTAMPED'), FILTER_VALIDATE_BOOLEAN),
    'tolerance' => (int) (getenv('WEBHOOK_TOLERANCE') ?: 0),
];
