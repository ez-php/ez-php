# Coding Guidelines

Applies to the entire ez-php project — framework core, all modules, and the application template.

---

## Environment

- PHP **8.5**, Composer for dependency management
- All project based commands run **inside Docker** — never directly on the host

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
1. `sync_guidelines.php --check` — fails if any `CLAUDE.md` has drifted from this file
2. `check_test_classes.php` — fails on a duplicate test class name (all packages share the `Tests\` namespace, so a collision is a fatal error in the aggregated run, not a test failure)
3. `phpstan analyse` — static analysis, level 9, config: `phpstan.neon`
4. `php-cs-fixer fix` — auto-fixes style (`@PSR12` + `@PHP83Migration` + strict rules)
   *(Note: `@PHP85Migration` does not exist yet in php-cs-fixer; `@PHP83Migration` is the highest available and is used intentionally even though the project targets PHP 8.5)*
5. `phpunit` — all tests with coverage

Individual commands when needed:
```
composer analyse             # PHPStan only
composer cs                  # CS Fixer only
composer test                # PHPUnit only
composer guidelines:check    # CLAUDE.md drift only
composer test-classes:check  # duplicate test class names only
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
- Concrete classes are `final` — extend behavior through composition, not inheritance. Exception-hierarchy base classes (e.g. `EzPhpException`, `HttpException`, `CacheException`) are one carve-out, since they exist specifically to be extended. A documented template-method-style base class (e.g. `Mailable`, meant to be configured via constructor-time subclassing) is the other — the owning module's `CLAUDE.md` must record it under Design Decisions.

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

### 1 — Required files

Every module under `modules/<name>/` must have:

| File | Purpose |
|---|---|
| `composer.json` | package definition, deps, autoload |
| `phpstan.neon` | static analysis config, level 9 |
| `phpunit.xml` | test suite config |
| `.php-cs-fixer.php` | code style config |
| `.gitignore` | ignore `vendor/`, `.env`, cache |
| `.env.example` | environment variable defaults (copy to `.env` on first run) |
| `docker-compose.yml` | Docker Compose service definition (always `container_name: ez-php-<name>-app`) |
| `docker/app/Dockerfile` | module Docker image (`FROM au9500/php:8.5`) |
| `docker/app/container-start.sh` | container entrypoint: `composer install` → `sleep infinity` |
| `docker/app/php.ini` | PHP ini overrides (`memory_limit`, `display_errors`, `xdebug.mode`) |
| `.github/workflows/ci.yml` | standalone CI pipeline |
| `README.md` | public documentation |
| `tests/TestCase.php` | base test case for the module |
| `start.sh` | convenience script: copy `.env`, bring up Docker, wait for services, exec shell |
| `CLAUDE.md` | see section 2 below |

### 2 — CLAUDE.md structure

Every module `CLAUDE.md` must follow this exact structure:

1. **Full content of `CODING_GUIDELINES.md`, verbatim** — copy it as-is, do not summarize or shorten
2. A `---` separator
3. `# Package: ez-php/<name>` (or `# Directory: <name>` for non-package directories)
4. Module-specific section covering:
   - Source structure — file tree with one-line description per file
   - Key classes and their responsibilities
   - Design decisions and constraints
   - Testing approach and infrastructure requirements (MySQL, Redis, etc.)
   - What does **not** belong in this module

**Do not edit part 1 by hand.** It is generated from `CODING_GUIDELINES.md` by
`sync_guidelines.php` at the project root:

```
php sync_guidelines.php            # rewrite every out-of-sync CLAUDE.md
php sync_guidelines.php --check    # report drift, exit 1 if any (CI / pre-commit)
```

Edit `CODING_GUIDELINES.md`, then run the script — it replaces everything before the
`# Package:` / `# Directory:` / `# Project:` heading and preserves the hand-written
section below it byte-for-byte. Editing a single copy only creates drift; before this
script existed, all 40 copies had diverged.

### 3 — Scaffolding a new module

`make_module.php` at the project root writes the required-file set and the monorepo
wiring in one step, wrapping `docker-init` for the Docker subset:

```
composer module:make <name> -- --description="..."
php make_module.php <name> --description="..." --services=mysql,redis
```

`<name>` is the kebab-case package name; the namespace is derived as
`EzPhp\<PascalCase>` unless `--namespace=` overrides it (`bignum` → `BigNum` and
`opcache` → `OPCache` are existing exceptions the guess gets wrong).

It writes `modules/<name>/` and registers the module in the four places the monorepo
needs it — root `composer.json` (`autoload.psr-4`), `phpstan.neon`, `phpunit.xml`
(test suite **and** coverage source), and `packages.sh` (alphabetical position).

Two things stay manual on purpose:

- **`CLAUDE.md` part 1** — only the `# Package:` section is generated. Run
  `composer guidelines:sync` afterwards; baking a guidelines copy into the generator
  would recreate the drift the sync script exists to prevent.
- **The host-port table below** (`--services` only) — editing it marks all ~40
  `CLAUDE.md` copies as drifted at once, so the next `composer full` would fail for
  a brand-new module. The generator prints which ports to claim instead.

### 4 — Docker scaffold

Run from the new module root (requires `"ez-php/docker": "^2.0"` in `require-dev`):

```
vendor/bin/docker-init
```

This copies `Dockerfile`, `docker-compose.yml`, `.env.example`, `start.sh`, and `docker/` into the module, replacing `{{MODULE_NAME}}` placeholders. Existing files are never overwritten.

Pass `--services` to merge MySQL/Redis/Meilisearch service definitions directly into `docker-compose.yml` and uncomment the matching sections in `.env.example`, instead of adapting them by hand afterward:

```
vendor/bin/docker-init --services=mysql
vendor/bin/docker-init --services=redis
vendor/bin/docker-init --services=meilisearch
vendor/bin/docker-init --services=mysql,redis
```

After scaffolding:

1. Adapt `docker-compose.yml` — add or remove services (MySQL, Redis, Meilisearch) as needed
2. Adapt `.env.example` — fill in connection defaults matching the services above
3. Assign a unique host port for each exposed service (see table below)

**Allocated host ports:**

| Package | `DB_HOST_PORT` (MySQL) | Redis host port | `MEILISEARCH_PORT` |
|---|---|---|---|
| root (`ez-php-project`) | 3306 | 6379 (`REDIS_PORT`) | 7700 |
| `ez-php/framework` | 3307 | — | — |
| `ez-php/orm` | 3309 | — | — |
| `ez-php/cache` | — | 6380 (`REDIS_HOST_PORT`) | — |
| `ez-php/queue` | 3310 | 6381 (`REDIS_HOST_PORT`) | — |
| `ez-php/rate-limiter` | — | 6382 (`REDIS_HOST_PORT`) | — |
| `ez-php/search` | — | — | 7701 |
| **next free** | **3311** | **6383** | **7702** |

Only set a port for services the module actually uses. Modules without external services need no port config.

> The `MEILISEARCH_PORT` column is the **host** port. Inside a Compose network the service is always reachable at `http://meilisearch:7700` regardless of the host mapping — only publish-side ports need to be unique.

> The "Redis host port" column is likewise the **host**-published port. `ez-php/cache`, `ez-php/queue`, and `ez-php/rate-limiter` map it through a separate `REDIS_HOST_PORT` env var in `docker-compose.yml`, keeping `REDIS_PORT` fixed at `6379` for in-container connections (the app container always reaches Redis at `redis:6379` over the Compose network, regardless of the host mapping) — the root project is the one exception, since it has no host/container split and uses `REDIS_PORT` for both.

### 5 — Monorepo scripts

`packages.sh` at the project root is the **central package registry**. Both `push_all.sh` and `update_all.sh` source it — the package list lives in exactly one place.

When adding a new module, add `"$ROOT/modules/<name>"` to the `PACKAGES` array in `packages.sh` in **alphabetical order** among the other `modules/*` entries (before `framework`, `ez-php`, and the root entry at the end).

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
│   ├── Entities/.gitkeep       — Data Mapper entity classes go here (namespace: App\Entities)
│   ├── Middleware/.gitkeep     — Application middleware go here (namespace: App\Middleware)
│   ├── Providers/.gitkeep      — Application service providers go here (namespace: App\Providers)
│   └── Repositories/.gitkeep  — Repository classes go here (namespace: App\Repositories)
├── config/
│   ├── ai.php                  — AI driver and per-provider credentials (env-backed)
│   ├── app.php                 — App name, debug flag, locale settings (env-backed)
│   ├── broadcast.php           — Broadcast driver and log path (env-backed)
│   ├── cache.php                — Cache driver and connection (env-backed)
│   ├── db.php                  — Database connection (env-backed)
│   ├── events.php              — Event class → listener class map (not env-backed)
│   ├── flags.php               — Feature flag driver and definitions-file path (env-backed; the definitions themselves live in ../flags.php)
│   ├── health.php              — Redis probe connection for /health (env-backed)
│   ├── mail.php                — Mail driver, SMTP connection, sender defaults (env-backed)
│   ├── queue.php                — Queue driver and Redis connection (env-backed)
│   ├── logging.php             — Log driver, path, level, JSON inner driver (env-backed)
│   ├── rate_limiter.php        — Rate limiter driver and Redis connection (env-backed)
│   ├── search.php              — Search driver, Meilisearch/Elasticsearch connection (env-backed)
│   ├── storage.php             — Storage driver, local path, S3 credentials (env-backed)
│   └── view.php                — View template path (env-backed)
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
├── .claude/commands/
│   ├── audit-app.md             — /audit-app: structural/config audit for a scaffolded app, findings to TODO.md
│   └── ideas.md                 — /ideas: sorts findings into IDEAS.md (project-specific) or EZ_PHP_IDEAS.md (module-generic)
├── IDEAS.md                    — project-specific ideas backlog (ships empty)
├── EZ_PHP_IDEAS.md             — ez-php module ideas surfaced by the application (ships empty)
├── .env.example                — Template for the .env file; copy to .env and fill in values
└── composer.json               — Project composer config; requires ez-php/framework, namespace App\
```

---

## Entry Points

### HTTP — `public/index.php`

The only file the web server should point to. Executed on every request.

```
1. require vendor/autoload.php
2. Dotenv::createImmutable(__DIR__ . '/..')->safeLoad()      — loads .env, skips if missing
3. RequestFactory::createFromGlobals()                        — builds Request from superglobals
4. new Application(__DIR__ . '/..')                           — basePath = application root
5. $app->bootstrap()                                          — loads providers, registers, boots
6. $app->handle($request)                                     — dispatches through middleware + router
7. $app->send($request, $response)                            — emits headers + body, then runs terminable middleware
```

`safeLoad()` is used (not `load()`) — the application starts without a `.env` file if all required variables are set in the real environment (e.g. Docker, CI/CD).

### CLI — `ez`

Executable PHP script. Executed as `php ez <command>` or `./ez <command>`.

```
1. require vendor/autoload.php
2. Dotenv::createImmutable(__DIR__)->safeLoad()
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

### `config/mail.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `MAIL_DRIVER` | `'null'` |
| `host` | `MAIL_HOST` | `'127.0.0.1'` |
| `port` | `MAIL_PORT` | `1025` |
| `username` | `MAIL_USERNAME` | `''` |
| `password` | `MAIL_PASSWORD` | `''` |
| `encryption` | `MAIL_ENCRYPTION` | `'none'` |
| `from_address` | `MAIL_FROM_ADDRESS` | `''` |
| `from_name` | `MAIL_FROM_NAME` | `''` |
| `log_path` | `MAIL_LOG_PATH` | `''` |

### `config/queue.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `QUEUE_DRIVER` | `'database'` |
| `redis.host` | `QUEUE_REDIS_HOST` | `'127.0.0.1'` |
| `redis.port` | `QUEUE_REDIS_PORT` | `6379` |
| `redis.database` | `QUEUE_REDIS_DB` | `0` |

### `config/logging.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `LOG_DRIVER` | `'file'` |
| `path` | `LOG_PATH` | `''` (falls back to `storage/logs`) |
| `max_bytes` | `LOG_MAX_BYTES` | `0` |
| `min_level` | `LOG_LEVEL` | `''` (all levels) |
| `json_inner` | `LOG_JSON_INNER` | `'stdout'` |
| `stack` | — | `['file', 'stdout']` |

### `config/rate_limiter.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `RATE_LIMITER_DRIVER` | `'array'` |
| `redis.host` | `RATE_LIMITER_REDIS_HOST` | `'127.0.0.1'` |
| `redis.port` | `RATE_LIMITER_REDIS_PORT` | `6379` |
| `redis.database` | `RATE_LIMITER_REDIS_DB` | `0` |

### `config/view.php`

| Key | Env var | Default |
|---|---|---|
| `path` | `VIEW_PATH` | `'resources/views'` |

### `config/broadcast.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `BROADCAST_DRIVER` | `'null'` |
| `log_path` | `BROADCAST_LOG_PATH` | `''` |

### `config/search.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `SEARCH_DRIVER` | `'null'` |
| `meilisearch.host` | `MEILISEARCH_HOST` | `'http://meilisearch:7700'` |
| `meilisearch.key` | `MEILISEARCH_KEY` | `''` |
| `elasticsearch.host` | `ELASTICSEARCH_HOST` | `'http://elasticsearch:9200'` |
| `elasticsearch.user` | `ELASTICSEARCH_USER` | `''` |
| `elasticsearch.password` | `ELASTICSEARCH_PASSWORD` | `''` |

### `config/ai.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `AI_DRIVER` | `'null'` |
| `stream_idle_timeout` | `AI_STREAM_IDLE_TIMEOUT` | `120` |
| `openai.api_key` | `OPENAI_API_KEY` | `''` |
| `openai.model` | `OPENAI_MODEL` | `'gpt-4o-mini'` |
| `openai.base_url` | `OPENAI_BASE_URL` | `'https://api.openai.com'` |
| `anthropic.api_key` | `ANTHROPIC_API_KEY` | `''` |
| `anthropic.model` | `ANTHROPIC_MODEL` | `'claude-sonnet-4-6'` |
| `anthropic.api_version` | `ANTHROPIC_API_VERSION` | `'2023-06-01'` |
| `gemini.api_key` | `GEMINI_API_KEY` | `''` |
| `gemini.model` | `GEMINI_MODEL` | `'gemini-2.0-flash'` |
| `mistral.api_key` | `MISTRAL_API_KEY` | `''` |
| `mistral.model` | `MISTRAL_MODEL` | `'mistral-small-latest'` |
| `mistral.base_url` | `MISTRAL_BASE_URL` | `'https://api.mistral.ai'` |
| `grok.api_key` | `GROK_API_KEY` | `''` |
| `grok.model` | `GROK_MODEL` | `'grok-3-mini'` |
| `grok.base_url` | `GROK_BASE_URL` | `'https://api.x.ai'` |
| `log.inner_driver` | `AI_LOG_INNER_DRIVER` | `'null'` |

### `config/events.php`

Not env-backed — maps event class-strings to arrays of listener class-strings.

| Key | Default |
|---|---|
| `listeners` | `[]` |

### `config/storage.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `STORAGE_DRIVER` | `'local'` |
| `local.root` | `STORAGE_ROOT` | `''` |
| `local.url` | `STORAGE_URL` | `''` |
| `s3.key` | `AWS_ACCESS_KEY_ID` | `''` |
| `s3.secret` | `AWS_SECRET_ACCESS_KEY` | `''` |
| `s3.region` | `AWS_DEFAULT_REGION` | `'us-east-1'` |
| `s3.bucket` | `AWS_BUCKET` | `''` |
| `s3.endpoint` | `AWS_ENDPOINT` | `null` |
| `s3.url` | `AWS_URL` | `null` |

### `config/health.php`

| Key | Env var | Default |
|---|---|---|
| `redis.host` | `REDIS_HOST` | `'127.0.0.1'` |
| `redis.port` | `REDIS_PORT` | `6379` |

### `config/flags.php`

| Key | Env var | Default |
|---|---|---|
| `driver` | `FLAGS_DRIVER` | `'file'` |
| `file` | `FLAGS_FILE` | `'flags.php'` |

The flag **definitions** live in `flags.php` at the application root, not in `config/`.
`ConfigLoader` globs `config/*.php` and keys each file by its basename, so a
definitions file at `config/flags.php` would be this config file: the `file` driver
would report `driver` and `file` as enabled flags and find none of the real ones.

---

## Provider Files

### `provider/core.php`

Documents the ordered list of core framework service providers (the kernel loads them from `EzPhp\Application\CoreServiceProviders::all()`). **Do not change the order** — providers have implicit dependencies (e.g. `RouterServiceProvider` needs `Config`, `ConsoleServiceProvider` needs `Migrator`).

```php
return [
    ConfigServiceProvider::class,
    TranslatorServiceProvider::class,
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
- **`app/` namespace is `App\`** — PSR-4 autoloading maps `App\` to `app/`. Controllers live in `App\Controllers`, entities in `App\Entities`, repositories in `App\Repositories`, etc. Do not change the namespace without updating `composer.json`.
- **No tests in the template** — This is a project template, not a library. Tests belong in the application that is created from it.
- **`.gitkeep` files** — Empty directories cannot be tracked by git. The `.gitkeep` files ensure the directory structure is preserved when the template is committed or distributed.
- **`IDEAS.md` / `EZ_PHP_IDEAS.md` ship empty, on purpose** — every application built from this template is expected to prefer an existing `ez-php/*` module over reimplementing generic functionality; when no module exists yet, the idea goes into `EZ_PHP_IDEAS.md` (module-generic) or `IDEAS.md` (project-specific) instead of being built ad hoc. See `NEW_PROJECT.md` §3 "Module Policy" / "Ideas Backlogs" — every generated project's own `CLAUDE.md` restates this rule verbatim.

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
