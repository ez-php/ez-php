<?php

declare(strict_types=1);

return [
    // OTLP/HTTP metrics URL, e.g. http://otel-collector:4318/v1/metrics; empty disables the export.
    'endpoint' => getenv('METRICS_OTLP_ENDPOINT') ?: '',
    // service.name resource attribute; empty uses app.name.
    'service_name' => getenv('METRICS_OTLP_SERVICE_NAME') ?: '',
    // Extra headers: key=value,key2=value2 (values URL-encoded).
    'headers' => getenv('METRICS_OTLP_HEADERS') ?: '',
    // Export once this many values are waiting; the rest is sent at process end.
    'max_points' => (int) (getenv('METRICS_OTLP_MAX_POINTS') ?: 1000),
    'timeout' => (int) (getenv('METRICS_OTLP_TIMEOUT') ?: 5),
];
