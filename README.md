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
| AI | `ez-php/ai` | Multi-provider AI client — OpenAI, Anthropic, Gemini, Mistral, Grok drivers |
| Audit | `ez-php/audit` | Event-driven audit log for entity create/update/delete |
| Auth | `ez-php/auth` | Session and Bearer token authentication |
| BigNum | `ez-php/bignum` | Arbitrary-precision integers and decimals (BCMath/GMP) |
| Broadcast | `ez-php/broadcast` | Real-time event broadcasting (SSE) |
| Cache | `ez-php/cache` | Array, File, Redis cache drivers |
| DataLoader | `ez-php/dataloader` | Keyed-batch loading and per-key memoization (N+1 prevention) |
| Events | `ez-php/events` | Synchronous event bus |
| Exchange | `ez-php/exchange` | Currency exchange-rate lookup and conversion for Money |
| Feature Flags | `ez-php/feature-flags` | Feature flag evaluation, File/Database/Array drivers |
| GraphQL | `ez-php/graphql` | GraphQL endpoint — schema builder and query executor |
| Health | `ez-php/health` | `/health` endpoint with DB, Redis, and Queue probes |
| HTTP Client | `ez-php/http-client` | Fluent cURL HTTP client |
| I18n | `ez-php/i18n` | File-based translator, dot-notation keys |
| JSON Schema | `ez-php/json-schema` | Attribute-driven JSON Schema emission for PHP classes |
| Log Transport | `ez-php/log-transport` | Async/remote log shipping (ELK, Datadog, Loki) for `ez-php/logging` |
| Logging | `ez-php/logging` | Structured logger, File/Stdout/Null drivers |
| Mail | `ez-php/mail` | Transactional email, SMTP/Log/Null drivers |
| Media | `ez-php/media` | Image resizing and file processing via GD/Imagick |
| Metrics | `ez-php/metrics` | Prometheus metrics endpoint — Counter, Gauge, Histogram |
| Money | `ez-php/money` | Immutable Money/Currency value objects, allocation, formatting |
| Notification | `ez-php/notification` | Multi-channel notifications (mail, broadcast, database) |
| OPcache | `ez-php/opcache` | OPcache preload script generation |
| OpenAPI | `ez-php/openapi` | OpenAPI 3.x spec generation from attributes |
| ORM | `ez-php/orm` | Active Record ORM, Query Builder, relations |
| Push | `ez-php/push` | Mobile push notifications (APNS, FCM) via `ez-php/notification` |
| Queue | `ez-php/queue` | Async job queue, database and Redis drivers |
| Rate Limiter | `ez-php/rate-limiter` | Rate limiting middleware |
| Scheduler | `ez-php/scheduler` | Cron-based job scheduler |
| Search | `ez-php/search` | Full-text search, Meilisearch/Elasticsearch |
| Storage | `ez-php/storage` | File storage abstraction, Local and S3 drivers |
| Swagger UI | `ez-php/swagger-ui` | Serves Swagger UI / ReDoc docs for the OpenAPI spec |
| Two-Factor | `ez-php/two-factor` | TOTP two-factor authentication, backup codes |
| Validation | `ez-php/validation` | Rule-based input validation |
| View | `ez-php/view` | PHP template engine, layouts, sections |
| View Cache | `ez-php/view-cache` | Output-caching decorator for `ez-php/view` |
| WebAuthn | `ez-php/webauthn` | WebAuthn / FIDO2 passkey authentication — registration and assertion ceremonies, attestation verification |
| WebSocket | `ez-php/websocket` | RFC 6455 WebSocket server (Fiber-based) |
| WebSocket TLS | `ez-php/websocket-tls` | TLS/WSS termination for `ez-php/websocket` |

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
