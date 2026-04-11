<?php

declare(strict_types=1);

/**
 * PHPUnit bootstrap for integration tests.
 *
 * Executed once before the test suite. Switches to the testing database,
 * boots the full application stack, runs all pending migrations, and seeds
 * the test database.
 *
 * Configure in phpunit.xml:
 *   <phpunit bootstrap="tests/bootstrap.php">
 *
 * Required .env keys:
 *   DB_TESTING_DATABASE  — name of the database used exclusively for tests.
 *                          Migrations and seeders run against this database,
 *                          not DB_DATABASE.
 */

use EzPhp\Application\Application;
use EzPhp\Contracts\ServiceProvider;
use EzPhp\Env\Dotenv;
use EzPhp\Migration\Migrator;
use EzPhp\Migration\SeederRunner;

require __DIR__ . '/../vendor/autoload.php';

Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();

// ── Switch to the test database ───────────────────────────────────────────────
// Reads DB_TESTING_DATABASE from the environment and replaces DB_DATABASE so
// that every framework component (DatabaseServiceProvider, Migrator, ORM, …)
// connects to the isolated test schema rather than the production database.

$testDb = $_ENV['DB_TESTING_DATABASE']
    ?? $_SERVER['DB_TESTING_DATABASE']
    ?? getenv('DB_TESTING_DATABASE');

if (is_string($testDb) && $testDb !== '') {
    putenv('DB_DATABASE=' . $testDb);
    $_ENV['DB_DATABASE'] = $testDb;
    $_SERVER['DB_DATABASE'] = $testDb;
}

// ── Boot the application ──────────────────────────────────────────────────────
// Core providers (Config, Database, Migration, Router, …) are loaded
// automatically. User/module providers from provider/modules.php are registered
// explicitly so that application-specific bindings (ORM models, repositories,
// custom services) are available during seeding.

$app = new Application(__DIR__ . '/..');

$modulesFile = __DIR__ . '/../provider/modules.php';

if (file_exists($modulesFile)) {
    /** @var list<class-string<ServiceProvider>> $providers */
    $providers = require $modulesFile;

    foreach ($providers as $providerClass) {
        $app->register($providerClass);
    }
}

$app->bootstrap();

// ── Migrate ───────────────────────────────────────────────────────────────────
// Runs every pending migration against the test database. Already-applied
// migrations are skipped, so re-running the suite is safe without a full reset.

$app->make(Migrator::class)->migrate();

// ── Seed ──────────────────────────────────────────────────────────────────────
// Seeds the test database with fixture data. Seeders are always executed in the
// test environment; no --force flag is required or checked here.

$app->make(SeederRunner::class)->run();
