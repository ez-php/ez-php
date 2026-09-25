<?php

declare(strict_types=1);

return [
    // Each capability picks its driver independently: openai, gemini or null.
    'image_driver' => getenv('AI_MEDIA_IMAGE_DRIVER') ?: 'null',
    'transcription_driver' => getenv('AI_MEDIA_TRANSCRIPTION_DRIVER') ?: 'null',
    'speech_driver' => getenv('AI_MEDIA_SPEECH_DRIVER') ?: 'null',
    'openai' => [
        'api_key' => getenv('OPENAI_API_KEY') ?: '',
        'base_url' => getenv('OPENAI_BASE_URL') ?: 'https://api.openai.com',
        'image_model' => getenv('AI_MEDIA_OPENAI_IMAGE_MODEL') ?: 'dall-e-3',
        'transcription_model' => getenv('AI_MEDIA_OPENAI_TRANSCRIPTION_MODEL') ?: 'whisper-1',
        'speech_model' => getenv('AI_MEDIA_OPENAI_SPEECH_MODEL') ?: 'tts-1',
    ],
    'gemini' => [
        'api_key' => getenv('GEMINI_API_KEY') ?: '',
        'base_url' => getenv('AI_MEDIA_GEMINI_BASE_URL') ?: 'https://generativelanguage.googleapis.com',
        'image_model' => getenv('AI_MEDIA_GEMINI_IMAGE_MODEL') ?: 'imagen-3.0-generate-002',
        'transcription_model' => getenv('AI_MEDIA_GEMINI_TRANSCRIPTION_MODEL') ?: 'gemini-2.0-flash',
        'speech_model' => getenv('AI_MEDIA_GEMINI_SPEECH_MODEL') ?: 'gemini-2.5-flash-preview-tts',
    ],
];
