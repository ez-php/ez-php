# ez-php

Application template for [ez-php](https://github.com/ez-php/framework) — a lightweight, modular PHP 8.5 framework.

## Requirements

- PHP 8.5+
- Composer
- Docker (recommended)

## Getting Started

```bash
cp .env.example .env
docker compose up -d
docker compose exec app composer install
docker compose exec app php ez migrate
```

Visit `http://localhost:${APP_PORT}` (default: `http://localhost:8001`).

## Optional Modules

Uncomment the relevant lines in `provider/modules.php` and install the package to activate a module.

| Module | Package | Purpose |
|---|---|---|
| Auth | `ez-php/auth` | Session and Bearer token authentication |
| Broadcast | `ez-php/broadcast` | Real-time event broadcasting (SSE) |
| Cache | `ez-php/cache` | Array, File, Redis cache drivers |
| Events | `ez-php/events` | Synchronous event bus |
| HTTP Client | `ez-php/http-client` | Fluent cURL HTTP client |
| I18n | `ez-php/i18n` | File-based translator, dot-notation keys |
| Logging | `ez-php/logging` | Structured logger, File/Stdout/Null drivers |
| Mail | `ez-php/mail` | Transactional email, SMTP/Log/Null drivers |
| ORM | `ez-php/orm` | Active Record ORM, Query Builder, relations |
| Queue | `ez-php/queue` | Async job queue, database and Redis drivers |
| Rate Limiter | `ez-php/rate-limiter` | Rate limiting middleware |
| Scheduler | `ez-php/scheduler` | Cron-based job scheduler |
| Search | `ez-php/search` | Full-text search, Meilisearch/Elasticsearch |
| Validation | `ez-php/validation` | Rule-based input validation |
| View | `ez-php/view` | PHP template engine, layouts, sections |
| Notification | `ez-php/notification` | Multi-channel notifications (mail, broadcast, database) |
| Storage | `ez-php/storage` | File storage abstraction, Local and S3 drivers |
| Health | `ez-php/health` | `/health` endpoint with DB, Redis, and Queue probes |
| Feature Flags | `ez-php/feature-flags` | Feature flag evaluation, File/Database/Array drivers |

Example:

```bash
composer require ez-php/orm
# then uncomment EzPhp\Orm\EntityServiceProvider::class in provider/modules.php
```

## Services (Docker)

| Service | Default port | Purpose |
|---|---|---|
| App (nginx) | 8001 | HTTP entry point |
| MySQL 8.4 | 3308 | Primary database |
| Redis 7 | 6381 | Cache / queue backend |
| Mailpit | 8025 (UI), 1025 (SMTP) | Local mail catcher |

## Quality Suite

```bash
docker compose exec app composer full       # PHPStan + CS Fixer + PHPUnit
docker compose exec app composer analyse    # PHPStan only
docker compose exec app composer cs         # CS Fixer only
docker compose exec app composer test       # PHPUnit only
```

## CLI

```bash
docker compose exec app php ez list              # list all commands
docker compose exec app php ez migrate           # run pending migrations
docker compose exec app php ez migrate:rollback  # roll back last batch
docker compose exec app php ez tinker            # interactive REPL
```
