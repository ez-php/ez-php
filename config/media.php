<?php

declare(strict_types=1);

return [
    // Image backend: gd (ext-gd) or imagick (ext-imagick).
    'driver' => getenv('MEDIA_DRIVER') ?: 'gd',
];
