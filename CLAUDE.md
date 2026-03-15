# Coding Guidelines

Applies to the entire ez-php project — framework core, all modules, and the application template.

---

## Environment

- PHP **8.5**, Composer for dependency management
- All commands run **inside Docker** — never directly on the host

```
docker compose exec app <command>
```

Container name: `ez-php-app`, service name: `app`.

---

## Quality Suite

Run after every change:

```
docker compose exec app composer full
```

Executes in order:
1. `phpstan analyse` — static analysis, level 9, config: `phpstan.neon`
2. `php-cs-fixer fix` — auto-fixes style (`@PSR12` + `@PHP83Migration` + strict rules)
3. `phpunit` — all tests with coverage

Individual commands when needed:
```
composer analyse   # PHPStan only
composer cs        # CS Fixer only
composer test      # PHPUnit only
```

**PHPStan:** never suppress with `@phpstan-ignore-line` — always fix the root cause.

---

## Coding Standards

- `declare(strict_types=1)` at the top of every PHP file
- Typed properties, parameters, and return values — avoid `mixed`
- PHPDoc on every class and public method
- One responsibility per class — keep classes small and focused
- Constructor injection — no service locator pattern
- No global state unless intentional and documented

**Naming:**

| Thing | Convention |
|---|---|
| Classes / Interfaces | `PascalCase` |
| Methods / variables | `camelCase` |
| Constants | `UPPER_CASE` |
| Files | Match class name exactly |

**Principles:** SOLID · KISS · DRY · YAGNI

---

## Workflow & Behavior

- Write tests **before or alongside** production code (test-first)
- Read and understand the relevant code before making any changes
- Modify the minimal number of files necessary
- Keep implementations small — if it feels big, it likely belongs in a separate module
- No hidden magic — everything must be explicit and traceable
- No large abstractions without clear necessity
- No heavy dependencies — check if PHP stdlib suffices first
- Respect module boundaries — don't reach across packages
- Keep the framework core small — what belongs in a module stays there
- Document architectural reasoning for non-obvious design decisions
- Do not change public APIs unless necessary
- Prefer composition over inheritance — no premature abstractions

---

## New Modules & CLAUDE.md Files

When creating a new module or `CLAUDE.md` anywhere in this repository:

**CLAUDE.md structure:**
- Start with the full content of `CODING_GUIDELINES.md`, verbatim
- Then add `---` followed by `# Package: ez-php/<name>` (or `# Directory: <name>`)
- Module-specific section must cover:
  - Source structure (file tree with one-line descriptions per file)
  - Key classes and their responsibilities
  - Design decisions and constraints
  - Testing approach and any infrastructure requirements (e.g. needs MySQL, Redis)
  - What does **not** belong in this module

**Each module needs its own:**
`composer.json` · `phpstan.neon` · `phpunit.xml` · `.php-cs-fixer.php` · `.gitignore` · `.github/workflows/ci.yml` · `README.md` · `tests/TestCase.php`

**Docker setup:**   
run `vendor/bin/docker-init` from the new module root to scaffold Docker files (requires `"ez-php/docker": "0.*"` in `require-dev`). The script reads the package name from `composer.json`, copies `Dockerfile`, `docker-compose.yml`, `.env.example`, `start.sh`, and `docker/` into the project, replacing `{{MODULE_NAME}}` placeholders — skips files that already exist. After scaffolding, adapt `docker-compose.yml` and `.env.example` for the module's required services (MySQL, Redis, etc.) and set a unique `DB_PORT` — increment by one per package starting with `3306` (root).

---

# Directory: ez-php

Project template for new ez-php applications. Contains the minimum required structure, entry points, and configuration to run a new application against the framework.

This template is **not a package** — it has no `phpstan.neon`, no `phpunit.xml`, and no tests of its own. It is copied as-is when creating a new project.

---

## Directory Structure

```
ez-php/
├── public/
│   └── index.php               — HTTP entry point: loads .env, boots Application, emits Response
├── ez                          — CLI entry point: loads .env, boots Application, runs Console
├── app/
│   ├── Controllers/.gitkeep    — Application controllers go here (namespace: App\Controllers)
│   ├── Middleware/.gitkeep     — Application middleware go here (namespace: App\Middleware)
│   ├── Models/.gitkeep         — ORM model classes go here (namespace: App\Models)
│   └── Providers/.gitkeep      — Application service providers go here (namespace: App\Providers)
├── config/
│   ├── app.php                 — App name, debug flag, locale settings (env-backed)
│   ├── db.php                  — Database connection (env-backed)
│   └── cache.php               — Cache driver and connection (env-backed)
├── database/
│   └── migrations/.gitkeep     — Migration files go here (loaded by Migrator)
├── lang/
│   ├── en/validation.php       — English validation error messages
│   └── de/validation.php       — German validation error messages
├── provider/
│   ├── core.php                — Ordered list of core framework service providers
│   └── modules.php             — Optional module service providers (uncomment to activate)
├── routes/
│   └── web.php                 — Route definitions; $router is injected by RouterServiceProvider
├── .env.example                — Template for the .env file; copy to .env and fill in values
└── composer.json               — Project composer config; requires ez-php/framework, namespace App\
```

---

## Entry Points

### HTTP — `public/index.php`

The only file the web server should point to. Executed on every request.

```
1. require vendor/autoload.php
2. Dotenv::createImmutable(__DIR__ . '/../..')->safeLoad()   — loads .env, skips if missing
3. RequestFactory::createFromGlobals()                        — builds Request from superglobals
4. new Application(__DIR__ . '/..')                           — basePath = application root
5. $app->bootstrap()                                          — loads providers, registers, boots
6. $app->handle($request)                                     — dispatches through middleware + router
7. ResponseEmitter::emit($response)                           — sends headers and body
```

`safeLoad()` is used (not `load()`) — the application starts without a `.env` file if all required variables are set in the real environment (e.g. Docker, CI/CD).

### CLI — `ez`

Executable PHP script. Executed as `php ez <command>` or `./ez <command>`.

```
1. require vendor/autoload.php
2. Dotenv::createImmutable(__DIR__ . '/..')->safeLoad()
3. new Application(__DIR__)                                   — basePath = application root (ez is in root)
4. $app->bootstrap()
5. $app->make(Console::class)->run($argv)
6. exit($exitCode)
```

The exit code from `Console::run()` is passed to `exit()` so shell scripts can detect command failures.

---

## Configuration Files

All config files return a plain PHP array. Values are read from the environment via `getenv()`.

### `config/app.php`

| Key | Env var | Default |
|---|---|---|
| `name` | `APP_NAME` | — |
| `debug` | `APP_DEBUG` | `false` (cast via `FILTER_VALIDATE_BOOLEAN`) |
| `locale` | `APP_LOCALE` | `'en'` |
| `fallback_locale` | `APP_FALLBACK_LOCALE` | `'en'` |

### `config/db.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `DB_DRIVER` | `'mysql'` |
| `host` | `DB_HOST` | — |
| `port` | `DB_PORT` | — |
| `database` | `DB_DATABASE` | — |
| `username` | `DB_USERNAME` | — |
| `password` | `DB_PASSWORD` | — |
| `testing_database` | `DB_TESTING_DATABASE` | — |

### `config/cache.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `CACHE_DRIVER` | `'array'` |
| `file_path` | `CACHE_PATH` | `sys_get_temp_dir() . '/ez-cache'` |
| `redis.host` | `CACHE_REDIS_HOST` | `'127.0.0.1'` |
| `redis.port` | `CACHE_REDIS_PORT` | `6379` |
| `redis.database` | `CACHE_REDIS_DB` | `0` |

---

## Provider Files

### `provider/core.php`

Returns the ordered list of core framework service providers. **Do not change the order** — providers have implicit dependencies (e.g. `RouterServiceProvider` needs `Config`, `ConsoleServiceProvider` needs `Migrator`).

```php
return [
    ConfigServiceProvider::class,
    DatabaseServiceProvider::class,
    MigrationServiceProvider::class,
    RouterServiceProvider::class,
    ExceptionHandlerServiceProvider::class,
    ConsoleServiceProvider::class,
];
```

### `provider/modules.php`

Returns optional module service providers. Uncomment or add entries to activate modules:

```php
return [
    EzPhp\Orm\ModelServiceProvider::class,
    EzPhp\Orm\Schema\SchemaServiceProvider::class,
    EzPhp\Cache\CacheServiceProvider::class,
    EzPhp\Events\EventServiceProvider::class,
    EzPhp\Auth\AuthServiceProvider::class,
    // ...
];
```

Application-level providers (e.g. `App\Providers\AppServiceProvider`) are also registered here.

---

## Routes — `routes/web.php`

The `$router` variable is injected into this file's scope by `RouterServiceProvider::boot()`. Define routes directly on it:

```php
$router->get('/', fn (Request $r) => new Response('Hello'));
$router->post('/users', [UserController::class, 'store']);
$router->group('/api', function (Router $r) {
    $r->get('/users', fn (Request $req) => ...);
});
```

---

## Language Files — `lang/`

PHP array files consumed by `ez-php/i18n` `Translator`. The template ships with `en` and `de` translation files for validation error messages. Add additional locales by creating `lang/<locale>/` directories.

---

## Design Decisions and Constraints

- **`basePath` is the application root** — both `public/index.php` and `ez` pass the application root as `basePath`. All framework path helpers (`$app->basePath('config')`, `basePath('lang')`, etc.) resolve relative to this directory.
- **`safeLoad()` not `load()`** — the application must start without a `.env` file when variables are injected via the real environment (Docker env vars, CI/CD secrets). `load()` would throw if the file is missing.
- **`provider/core.php` vs `provider/modules.php`** — Core providers are always loaded and always in the same order (managed by the framework). Module providers are opt-in. This separation makes it clear what is mandatory and what is optional.
- **`app/` namespace is `App\`** — PSR-4 autoloading maps `App\` to `app/`. Controllers live in `App\Controllers`, models in `App\Models`, etc. Do not change the namespace without updating `composer.json`.
- **No tests in the template** — This is a project template, not a library. Tests belong in the application that is created from it.
- **`.gitkeep` files** — Empty directories cannot be tracked by git. The `.gitkeep` files ensure the directory structure is preserved when the template is committed or distributed.

---

## Starting a New Application from the Skeleton

1. Copy the ez-php directory to the new project location
2. Copy `.env.example` to `.env` and fill in values
3. Run `composer install`
4. Point the web server document root to `public/`
5. Make `ez` executable: `chmod +x ez`
6. Run `php ez migrate` to apply migrations (if any)

---

## What Does NOT Belong Here

| Concern | Where it belongs |
|---|---|
| Framework source code | `framework/` |
| Reusable module packages | `modules/*/` |
| Application business logic | The app created from this template |
| Tests for the template structure | Not applicable — ez-php is a template |
| Docker configuration | `docker/` (monorepo root) |
