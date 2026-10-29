<?php

declare(strict_types=1);

return [
    // Path of the viewer page; empty registers no route.
    'endpoint' => getenv('ASYNCAPI_UI_ENDPOINT') ?: '/asyncapi-docs',
    // URL the page loads the document from; empty uses asyncapi.endpoint (ez-php/asyncapi).
    'document_url' => getenv('ASYNCAPI_UI_DOCUMENT_URL') ?: '',
];
