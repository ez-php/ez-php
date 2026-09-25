<?php

declare(strict_types=1);

return [
    // apns, fcm, webpush or null.
    'driver' => getenv('PUSH_DRIVER') ?: 'null',
    'apns' => [
        'private_key' => getenv('PUSH_APNS_PRIVATE_KEY') ?: '',
        'key_id' => getenv('PUSH_APNS_KEY_ID') ?: '',
        'team_id' => getenv('PUSH_APNS_TEAM_ID') ?: '',
        'bundle_id' => getenv('PUSH_APNS_BUNDLE_ID') ?: '',
        'sandbox' => filter_var(getenv('PUSH_APNS_SANDBOX'), FILTER_VALIDATE_BOOLEAN),
    ],
    'fcm' => [
        'private_key' => getenv('PUSH_FCM_PRIVATE_KEY') ?: '',
        'project_id' => getenv('PUSH_FCM_PROJECT_ID') ?: '',
        'client_email' => getenv('PUSH_FCM_CLIENT_EMAIL') ?: '',
    ],
    'webpush' => [
        'private_key' => getenv('PUSH_WEBPUSH_PRIVATE_KEY') ?: '',
        'subject' => getenv('PUSH_WEBPUSH_SUBJECT') ?: '',
        'ttl' => (int) (getenv('PUSH_WEBPUSH_TTL') ?: 86400),
    ],
];
