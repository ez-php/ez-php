<?php

declare(strict_types=1);

return [
    // Path of the documentation page.
    'endpoint' => getenv('SWAGGER_UI_ENDPOINT') ?: '/docs',
    // URL the page fetches the OpenAPI spec from (ez-php/openapi's endpoint).
    'spec_url' => getenv('SWAGGER_UI_SPEC_URL') ?: '/openapi.json',
    // 'swagger-ui' or 'redoc'.
    'renderer' => getenv('SWAGGER_UI_RENDERER') ?: 'swagger-ui',
];
