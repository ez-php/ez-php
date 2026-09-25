<?php

declare(strict_types=1);

return [
    // Route the GraphQL endpoint is registered on.
    'endpoint' => getenv('GRAPHQL_ENDPOINT') ?: '/graphql',
    // Query limits enforced before execution.
    'max_query_depth' => (int) (getenv('GRAPHQL_MAX_QUERY_DEPTH') ?: 15),
    'max_query_complexity' => (int) (getenv('GRAPHQL_MAX_QUERY_COMPLEXITY') ?: 200),
    // Automatic persisted queries (needs a bound ez-php/cache CacheInterface).
    'persisted_queries' => filter_var(getenv('GRAPHQL_PERSISTED_QUERIES'), FILTER_VALIDATE_BOOLEAN),
    // 0 = keep persisted queries forever.
    'persisted_queries_ttl' => (int) (getenv('GRAPHQL_PERSISTED_QUERIES_TTL') ?: 0),
];
