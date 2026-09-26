<?php

declare(strict_types=1);

return [
    'driver' => getenv('MAIL_DRIVER') ?: 'null',
    'host' => getenv('MAIL_HOST') ?: '127.0.0.1',
    'port' => (int) (getenv('MAIL_PORT') ?: 1025),
    'username' => getenv('MAIL_USERNAME') ?: '',
    'password' => getenv('MAIL_PASSWORD') ?: '',
    'encryption' => getenv('MAIL_ENCRYPTION') ?: 'none',
    'from_address' => getenv('MAIL_FROM_ADDRESS') ?: '',
    'from_name' => getenv('MAIL_FROM_NAME') ?: '',
    'log_path' => getenv('MAIL_LOG_PATH') ?: '',
    // Network timeout in seconds for smtp, mailgun and sendgrid
    'timeout' => (int) (getenv('MAIL_TIMEOUT') ?: 30),
    // driver = mailgun
    'mailgun_domain' => getenv('MAILGUN_DOMAIN') ?: '',
    'mailgun_secret' => getenv('MAILGUN_SECRET') ?: '',
    'mailgun_region' => getenv('MAILGUN_REGION') ?: 'us',
    // driver = sendgrid
    'sendgrid_api_key' => getenv('SENDGRID_API_KEY') ?: '',
];
