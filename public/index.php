<?php

declare(strict_types=1);

use EzPhp\Application\Application;
use EzPhp\Env\Dotenv;
use EzPhp\Http\RequestFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$request = RequestFactory::createFromGlobals();

$app = new Application(__DIR__ . '/..');
$app->bootstrap();

$app->send($request, $app->handle($request));
