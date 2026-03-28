<?php

declare(strict_types=1);

return [
    'driver' => getenv('BROADCAST_DRIVER') ?: 'null',
    'log_path' => getenv('BROADCAST_LOG_PATH') ?: '',
];
