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
    'postmark' => [
        // Basic credentials you put into the Postmark webhook URL (https://user:pass@host/path); empty registers no route.
        'username' => getenv('MAIL_EVENTS_POSTMARK_USERNAME') ?: '',
        'password' => getenv('MAIL_EVENTS_POSTMARK_PASSWORD') ?: '',
        'path' => getenv('MAIL_EVENTS_POSTMARK_PATH') ?: '/webhooks/mail/postmark',
    ],
    'ses' => [
        // ARN of the SNS topic your SES configuration set publishes to; empty registers no route.
        'topic_arn' => getenv('MAIL_EVENTS_SES_TOPIC_ARN') ?: '',
        'path' => getenv('MAIL_EVENTS_SES_PATH') ?: '/webhooks/mail/ses',
    ],
];
