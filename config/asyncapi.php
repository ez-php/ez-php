<?php

declare(strict_types=1);

return [
    // URI the generated AsyncAPI document is served from.
    'endpoint' => getenv('ASYNCAPI_ENDPOINT') ?: '/asyncapi.json',

    // Message classes to document — each carries #[Channel] and #[Message]
    // (EzPhp\AsyncApi\Attributes). Nothing is discovered automatically, e.g.
    // [App\Events\OrderShipped::class].
    'classes' => [],

    // AsyncAPI Server Objects keyed by name, e.g.
    // 'production' => ['host' => 'ws.example.com', 'protocol' => 'wss'].
    'servers' => [],
];
