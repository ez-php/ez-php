<?php

declare(strict_types=1);

return [
    // twilio, vonage, log or null.
    'driver' => getenv('SMS_DRIVER') ?: 'null',
    // Default sender: E.164 number or alphanumeric sender ID.
    'from' => getenv('SMS_FROM') ?: '',
    // Log driver file; empty writes via error_log().
    'log_path' => getenv('SMS_LOG_PATH') ?: '',
    'twilio' => [
        'sid' => getenv('SMS_TWILIO_SID') ?: '',
        'token' => getenv('SMS_TWILIO_TOKEN') ?: '',
    ],
    'vonage' => [
        'key' => getenv('SMS_VONAGE_KEY') ?: '',
        'secret' => getenv('SMS_VONAGE_SECRET') ?: '',
    ],
];
