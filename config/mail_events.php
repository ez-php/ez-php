<?php

declare(strict_types=1);

return [
    // Max. age of a webhook timestamp in seconds; older requests are rejected.
    'tolerance' => (int) (getenv('MAIL_EVENTS_TOLERANCE') ?: 300),
    'mailgun' => [
        // Mailgun "HTTP webhook signing key"; empty registers no route.
        'signing_key' => getenv('MAIL_EVENTS_MAILGUN_SIGNING_KEY') ?: '',
        'path' => getenv('MAIL_EVENTS_MAILGUN_PATH') ?: '/webhooks/mail/mailgun',
    ],
    'sendgrid' => [
        // Signed Event Webhook verification key (base64 or PEM); empty registers no route.
        'public_key' => getenv('MAIL_EVENTS_SENDGRID_PUBLIC_KEY') ?: '',
        'path' => getenv('MAIL_EVENTS_SENDGRID_PATH') ?: '/webhooks/mail/sendgrid',
    ],
];
