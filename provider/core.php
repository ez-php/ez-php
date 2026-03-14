<?php

declare(strict_types=1);

use EzPhp\Config\ConfigServiceProvider;
use EzPhp\Console\ConsoleServiceProvider;
use EzPhp\Database\DatabaseServiceProvider;
use EzPhp\Exceptions\ExceptionHandlerServiceProvider;
use EzPhp\Migration\MigrationServiceProvider;
use EzPhp\Routing\RouterServiceProvider;

return [
    ConfigServiceProvider::class,
    DatabaseServiceProvider::class,
    MigrationServiceProvider::class,
    RouterServiceProvider::class,
    ExceptionHandlerServiceProvider::class,
    ConsoleServiceProvider::class,
];
