<?php

declare(strict_types=1);

return [
    'driver' => getenv('SEARCH_DRIVER') ?: 'null',
    'meilisearch' => [
        'host' => getenv('MEILISEARCH_HOST') ?: 'http://meilisearch:7700',
        'key' => getenv('MEILISEARCH_KEY') ?: '',
    ],
    'elasticsearch' => [
        'host' => getenv('ELASTICSEARCH_HOST') ?: 'http://elasticsearch:9200',
        'user' => getenv('ELASTICSEARCH_USER') ?: '',
        'password' => getenv('ELASTICSEARCH_PASSWORD') ?: '',
    ],
];
