<?php

declare(strict_types=1);

use EzPhp\Application\Application;
use EzPhp\Env\Dotenv;
use EzPhp\Http\RequestFactory;
use EzPhp\Http\ResponseEmitter;

require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

$request = RequestFactory::createFromGlobals();

$app = new Application(__DIR__ . '/..');
$app->bootstrap();

$response = $app->handle($request);

$emitter = new ResponseEmitter();
$emitter->emit($response);
