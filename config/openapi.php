<?php

declare(strict_types=1);

return [
    // URI the generated spec is served from.
    'endpoint' => getenv('OPENAPI_ENDPOINT') ?: '/openapi.json',

    // Reusable OpenAPI component objects merged into the generated spec.
    //
    // ez-php/openapi never derives schemas from your classes — that stays your
    // responsibility. Declare them here so the $ref values emitted by
    // #[ApiResponse(200, User::class)] actually resolve:
    //
    //   'components' => [
    //       'schemas' => [
    //           'User' => [
    //               'type' => 'object',
    //               'properties' => [
    //                   'id'    => ['type' => 'integer'],
    //                   'email' => ['type' => 'string', 'format' => 'email'],
    //               ],
    //           ],
    //       ],
    //   ],
    //
    // The key is omitted from the spec entirely while this array is empty.
    'components' => [],
];
