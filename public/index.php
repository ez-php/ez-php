<?php

declare(strict_types=1);

use EzPhp\Application\Application;
use EzPhp\Contracts\ServiceProvider;
use EzPhp\Env\Dotenv;
use EzPhp\Http\RequestFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$request = RequestFactory::createFromGlobals();

$app = new Application(__DIR__ . '/..');

// Module and application providers (provider/modules.php) are not loaded by the
// kernel itself — only the core providers are. Register them before bootstrap().
/** @var list<class-string<ServiceProvider>> $providers */
$providers = require __DIR__ . '/../provider/modules.php';

foreach ($providers as $providerClass) {
    $app->register($providerClass);
}

$app->bootstrap();

$app->send($request, $app->handle($request));
