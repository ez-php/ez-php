<?php

declare(strict_types=1);

return [
    'driver' => getenv('FLAGS_DRIVER') ?: 'file',
    'file'   => getenv('FLAGS_FILE') ?: 'config/flags.php',
];
