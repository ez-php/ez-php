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
];
