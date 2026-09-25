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
        // Streams larger than this use multipart upload (S3 minimum part size: 5 MiB).
        'multipart_part_size' => (int) (getenv('STORAGE_S3_MULTIPART_PART_SIZE') ?: 8_388_608),
    ],
    'gcs' => [
        'bucket' => getenv('GCS_BUCKET') ?: '',
        // OAuth2 Bearer token; obtaining/refreshing it is the application's job.
        'access_token' => getenv('GCS_ACCESS_TOKEN') ?: '',
        'url' => getenv('GCS_URL') ?: null,
    ],
];
