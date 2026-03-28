<?php

declare(strict_types=1);

return [
    'driver' => getenv('STORAGE_DRIVER') ?: 'local',
    'local' => [
        'root' => getenv('STORAGE_ROOT') ?: '',
        'url' => getenv('STORAGE_URL') ?: '',
    ],
    's3' => [
        'key' => getenv('AWS_ACCESS_KEY_ID') ?: '',
        'secret' => getenv('AWS_SECRET_ACCESS_KEY') ?: '',
        'region' => getenv('AWS_DEFAULT_REGION') ?: 'us-east-1',
        'bucket' => getenv('AWS_BUCKET') ?: '',
        'endpoint' => getenv('AWS_ENDPOINT') ?: null,
        'url' => getenv('AWS_URL') ?: null,
        'url_expiry' => (int) (getenv('STORAGE_S3_URL_EXPIRY') ?: 3600),
    ],
];
