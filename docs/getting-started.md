# Getting Started with ez-php

A step-by-step guide for creating your first ez-php application.

---

## Requirements

- PHP **8.5+** with extensions: `pdo_mysql`, `mbstring`
- Composer 2
- Docker + Docker Compose (recommended for local development)

---

## 1 — Create a new project

Copy the `ez-php` template directory to your project location (or clone the repository):

```bash
cp -r ez-php/ my-app/
cd my-app/
```

---

## 2 — Install dependencies

```bash
composer install
```

---

## 3 — Configure the environment

```bash
cp .env.example .env
```

Edit `.env` and adjust the values for your environment. The defaults work with the included Docker Compose setup.

---

## 4 — Start Docker

```bash
docker compose up -d
```

This starts:
- **app** — PHP 8.5 application container (port `APP_PORT`, default 8000)
- **db** — MySQL 8.4 (port `DB_HOST_PORT`, default 3306)
- **redis** — Redis 7 (port `REDIS_PORT`, default 6379)
- **mailpit** — Mail test server (SMTP port `MAIL_PORT` 1025, web UI `MAIL_WEB_PORT` 8025)

Wait until the DB healthcheck passes (usually a few seconds), then open a shell:

```bash
docker compose exec app bash
```

All subsequent commands run **inside the container** unless otherwise noted.

---

## 5 — Run migrations

```bash
php ez migrate
```

This creates the `migrations` table and runs any migration files in `database/migrations/`.

---

## 6 — Open the application

Visit [http://localhost:8000](http://localhost:8000) — you should see `Hello from ez-php!`.

---

## 7 — Add your first route

Edit `routes/web.php`:

```php
use EzPhp\Http\Request;
use EzPhp\Http\Response;
use EzPhp\Routing\Router;

/** @var Router $router */
$router->get('/', fn (Request $r) => new Response('Hello from ez-php!'));

$router->get('/hello/{name}', function (Request $r, string $name): Response {
    return new Response("Hello, {$name}!");
});
```

Visit [http://localhost:8000/hello/world](http://localhost:8000/hello/world).

---

## 8 — Create a controller

```bash
php ez make:controller UserController
```

This generates `app/Controllers/UserController.php`. Register the route:

```php
use App\Controllers\UserController;

$router->get('/users', [UserController::class, 'index']);
$router->post('/users', [UserController::class, 'store']);
```

---

## 9 — Add a migration

```bash
php ez make:migration create_users_table
```

Edit the generated file in `database/migrations/`:

```php
use EzPhp\Migration\MigrationInterface;

return new class implements MigrationInterface {
    public function up(\PDO $db): void
    {
        $db->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function down(\PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS users");
    }
};
```

Apply it:

```bash
php ez migrate
```

---

## 10 — Activate optional modules

Install the Composer package and uncomment the corresponding line in `provider/modules.php`.

### ORM

```bash
composer require ez-php/orm
```

```php
// provider/modules.php
EzPhp\Orm\EntityServiceProvider::class,
EzPhp\Orm\Schema\SchemaServiceProvider::class,
```

### Cache

```bash
composer require ez-php/cache
```

```php
EzPhp\Cache\CacheServiceProvider::class,
```

### Mail

```bash
composer require ez-php/mail
```

```php
EzPhp\Mail\MailServiceProvider::class,
```

Mail is pre-configured to use Mailpit in local development. Open [http://localhost:8025](http://localhost:8025) to see sent messages.

### Events

```bash
composer require ez-php/events
```

```php
EzPhp\Events\EventServiceProvider::class,
```

### Auth

```bash
composer require ez-php/auth
```

```php
EzPhp\Auth\AuthServiceProvider::class,
```

### Queue

```bash
composer require ez-php/queue
```

```php
EzPhp\Queue\QueueServiceProvider::class,
```

Start the queue worker:

```bash
php ez queue:work
```

See `provider/modules.php` for a full list of available modules.

---

## 11 — Run tests

```bash
composer test
```

PHPUnit looks for tests in `tests/`. Use the base classes from `ez-php/testing-application` for application-level tests:

```php
use EzPhp\Testing\HttpTestCase;

class UserControllerTest extends HttpTestCase
{
    public function testIndex(): void
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
    }
}
```

---

## 12 — Quality suite

Run the full quality suite (static analysis + code style + tests):

```bash
composer full
```

Individual commands:

```bash
composer analyse   # PHPStan level 9
composer cs        # php-cs-fixer (auto-fix)
composer test      # PHPUnit with coverage
```

---

## Available CLI commands

```bash
php ez list                 # show all commands
php ez migrate              # run pending migrations
php ez migrate:rollback     # roll back the last batch
php ez migrate:fresh        # drop all tables and re-migrate
php ez migrate:status       # show migration status
php ez make:controller Foo  # generate a controller
php ez make:migration name  # generate a migration file
php ez make:middleware Foo  # generate a middleware
php ez make:provider Foo    # generate a service provider
php ez serve                # start the built-in PHP server (without Docker)
php ez tinker               # interactive REPL
php ez queue:work           # start queue worker (requires ez-php/queue)
```

---

## Directory overview

```
app/
  Controllers/   — HTTP controllers
  Middleware/    — Application middleware
  Models/        — ORM models (if using ez-php/orm)
  Providers/     — Application service providers
config/
  app.php        — APP_* env vars
  db.php         — DB_* env vars
  cache.php      — CACHE_* env vars
  mail.php       — MAIL_* env vars
database/
  migrations/    — Migration files
lang/
  en/            — Translation files (English)
  de/            — Translation files (German)
provider/
  core.php       — Framework core providers (do not modify order)
  modules.php    — Optional module providers (add/uncomment to activate)
routes/
  web.php        — Route definitions
public/
  index.php      — HTTP entry point (document root)
ez               — CLI entry point
```

---

## Next steps

- [CONFIG.md](CONFIG.md) — all `.env` / config keys across every module
- [docs/testing-guide.md](testing-guide.md) — test base classes and patterns
- [docs/upgrade-active-record-to-data-mapper.md](upgrade-active-record-to-data-mapper.md) — ORM migration guide
