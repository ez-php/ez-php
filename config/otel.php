<?php

declare(strict_types=1);

return [
    'exporter' => getenv('OTEL_EXPORTER') ?: null,
    'endpoint' => getenv('OTEL_EXPORTER_OTLP_ENDPOINT') ?: null,
    'service_name' => getenv('OTEL_SERVICE_NAME') ?: 'ez-php-app',
];
