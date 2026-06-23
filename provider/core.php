<?php

declare(strict_types=1);

use EzPhp\Config\ConfigServiceProvider;
use EzPhp\Console\ConsoleServiceProvider;
use EzPhp\Database\DatabaseServiceProvider;
use EzPhp\Exceptions\ExceptionHandlerServiceProvider;
use EzPhp\I18n\TranslatorServiceProvider;
use EzPhp\Migration\MigrationServiceProvider;
use EzPhp\Routing\RouterServiceProvider;

// Reference list of the core providers, in load order. The kernel actually
// loads these from EzPhp\Application\CoreServiceProviders::all(); keep this in
// sync with that list. Do not reorder — providers have implicit dependencies.
return [
    ConfigServiceProvider::class,
    TranslatorServiceProvider::class,
    DatabaseServiceProvider::class,
    MigrationServiceProvider::class,
    RouterServiceProvider::class,
    ExceptionHandlerServiceProvider::class,
    ConsoleServiceProvider::class,
];
