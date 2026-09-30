<?php

declare(strict_types=1);

return [
    'exporter' => getenv('OTEL_EXPORTER') ?: null,
    'endpoint' => getenv('OTEL_EXPORTER_OTLP_ENDPOINT') ?: null,
    'service_name' => getenv('OTEL_SERVICE_NAME') ?: 'ez-php-app',
    // OTLP only: share of traces kept (0.0–1.0), and spans per export call (0 = one call per span).
    'sample_ratio' => is_numeric(getenv('OTEL_SAMPLE_RATIO')) ? (float) getenv('OTEL_SAMPLE_RATIO') : 1.0,
    'batch_size' => is_numeric(getenv('OTEL_BATCH_SIZE')) ? (int) getenv('OTEL_BATCH_SIZE') : 512,
];
