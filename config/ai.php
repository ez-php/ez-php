<?php

declare(strict_types=1);

return [
    'driver' => getenv('AI_DRIVER') ?: 'null',
    'openai' => [
        'api_key' => getenv('OPENAI_API_KEY') ?: '',
        'model' => getenv('OPENAI_MODEL') ?: 'gpt-4o-mini',
        'base_url' => getenv('OPENAI_BASE_URL') ?: 'https://api.openai.com',
    ],
    'anthropic' => [
        'api_key' => getenv('ANTHROPIC_API_KEY') ?: '',
        'model' => getenv('ANTHROPIC_MODEL') ?: 'claude-sonnet-4-6',
        'api_version' => getenv('ANTHROPIC_API_VERSION') ?: '2023-06-01',
    ],
    'gemini' => [
        'api_key' => getenv('GEMINI_API_KEY') ?: '',
        'model' => getenv('GEMINI_MODEL') ?: 'gemini-2.0-flash',
    ],
    'mistral' => [
        'api_key' => getenv('MISTRAL_API_KEY') ?: '',
        'model' => getenv('MISTRAL_MODEL') ?: 'mistral-small-latest',
        'base_url' => getenv('MISTRAL_BASE_URL') ?: 'https://api.mistral.ai',
    ],
    'grok' => [
        'api_key' => getenv('GROK_API_KEY') ?: '',
        'model' => getenv('GROK_MODEL') ?: 'grok-3-mini',
        'base_url' => getenv('GROK_BASE_URL') ?: 'https://api.x.ai',
    ],
    'log' => [
        'inner_driver' => getenv('AI_LOG_INNER_DRIVER') ?: 'null',
    ],
];
