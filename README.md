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

Every ez-php module except the framework's own plumbing (`contracts`, `console`, `dotenv`, `http`), the dev-only testing packages (`testing`, `testing-application`) and the `docker` tooling. Install the package with Composer; modules that ship a service provider are activated by uncommenting their line in `provider/modules.php`, libraries are used directly. `i18n` and `validation` already come with the framework.

| Module | Package | Purpose |
|---|---|---|
| AI | `ez-php/ai` | Multi-provider AI client — OpenAI, Anthropic, Gemini, Mistral, Grok drivers |
| AI Media | `ez-php/ai-media` | Image generation, audio transcription, and text-to-speech — OpenAI/Gemini drivers |
| AsyncAPI | `ez-php/asyncapi` | AsyncAPI 3.0 documentation for broadcast channels, webhooks and WebSocket messages |
| AsyncAPI UI | `ez-php/asyncapi-ui` | HTML viewer for the AsyncAPI document (AsyncAPI React component from a CDN) |
| Audit | `ez-php/audit` | Event-driven audit log for entity create/update/delete |
| Auth | `ez-php/auth` | Session, Bearer token, JWT and personal access token authentication |
| Authorization | `ez-php/authorization` | Gate and policy based authorization — abilities, policies, `CanMiddleware` |
| BigNum | `ez-php/bignum` | Arbitrary-precision integers and decimals (BCMath/GMP) |
| Broadcast | `ez-php/broadcast` | Real-time event broadcasting, Null/Log/Redis/Array/WebSocket drivers (SSE responses via `ez-php/http`) |
| Cache | `ez-php/cache` | Array, File, Redis, Memcached, Database, APCu cache drivers |
| DataLoader | `ez-php/dataloader` | Keyed-batch loading and per-key memoization (N+1 prevention) |
| Encryption | `ez-php/encryption` | Authenticated encryption with key rotation, encrypted cookies, ORM cast |
| Event Store | `ez-php/event-store` | Append-only event store with stream replay and projections |
| Event Store Snapshots | `ez-php/event-store-snapshots` | Snapshots for event-store streams — replay only the events after the latest snapshot |
| Events | `ez-php/events` | Synchronous event bus |
| Exchange | `ez-php/exchange` | Currency exchange-rate lookup and conversion for Money |
| Feature Flags | `ez-php/feature-flags` | Feature flag evaluation, File/Database/Redis/Array/Rollout drivers |
| GraphQL | `ez-php/graphql` | GraphQL endpoint — schema builder and query executor |
| GraphQL Subscriptions | `ez-php/graphql-subscriptions` | GraphQL subscriptions over WebSocket (`graphql-transport-ws`), fed by broadcast events |
| Health | `ez-php/health` | `/health` endpoint with DB, Redis, Queue, RedisQueue, OPcache and disk-space probes (plus opt-in cache and HTTP probes) |
| HTTP Client | `ez-php/http-client` | Fluent cURL HTTP client |
| I18n | `ez-php/i18n` | File-based translator, dot-notation keys |
| Idempotency | `ez-php/idempotency` | `Idempotency-Key` middleware — safe retries for POST/PATCH/PUT/DELETE |
| JSON Schema | `ez-php/json-schema` | Attribute-driven JSON Schema emission for PHP classes |
| JSON Schema Validator | `ez-php/json-schema-validator` | Validates JSON payloads against generated schemas, JSON Pointer errors |
| Log Transport | `ez-php/log-transport` | Async/remote log shipping (ELK/NDJSON, Datadog, Loki, New Relic, Splunk HEC, Graylog GELF) for `ez-php/logging` |
| Logging | `ez-php/logging` | Structured logger, File/Stdout/Syslog/Json/Stack/MinLevel/Null drivers |
| Mail | `ez-php/mail` | Transactional email, SMTP/Mailgun/SendGrid/Log/Null drivers |
| Mail Events | `ez-php/mail-events` | Mailgun/SendGrid/Postmark/SES delivery webhooks (bounces, complaints, opens, clicks) as events |
| Media | `ez-php/media` | Image resizing and file processing via GD/Imagick |
| Metrics | `ez-php/metrics` | Prometheus metrics endpoint — Counter, Gauge, Histogram |
| Metrics OTLP | `ez-php/metrics-otlp` | OTLP/HTTP exporter for `ez-php/metrics` to an OpenTelemetry collector |
| Metrics StatsD | `ez-php/metrics-statsd` | StatsD/UDP exporter for `ez-php/metrics` |
| Money | `ez-php/money` | Immutable Money/Currency value objects, allocation, formatting |
| Notification | `ez-php/notification` | Multi-channel notifications (mail, broadcast, database, push, sms, webhook channels) |
| OAuth | `ez-php/oauth` | OAuth2/SSO client flows — authorization code flow with PKCE and state, OpenID Connect ID token validation |
| OPcache | `ez-php/opcache` | OPcache preload script generation |
| OpenAPI | `ez-php/openapi` | OpenAPI 3.x spec generation from attributes |
| ORM | `ez-php/orm` | Data Mapper ORM (entities + repositories), Query Builder, relations, keyset iteration |
| OpenTelemetry | `ez-php/otel` | OpenTelemetry spans and OTLP/HTTP JSON export without a vendor SDK; HTTP, database, log and queue tracing |
| PSR Bridge | `ez-php/psr-bridge` | PSR-7/PSR-15/PSR-3 adapters for third-party middleware and loggers |
| Push | `ez-php/push` | Mobile and browser push notifications (APNS, FCM, Web Push) via `ez-php/notification` |
| QR Code | `ez-php/qrcode` | Dependency-free QR code encoder with SVG and PNG output |
| Queue | `ez-php/queue` | Async job queue, database and Redis drivers |
| Rate Limiter | `ez-php/rate-limiter` | Rate limiting, Array/File/Redis/SlidingWindowRedis/Cache drivers, `ThrottleMiddleware` |
| Scheduler | `ez-php/scheduler` | Cron-based job scheduler |
| Search | `ez-php/search` | Full-text search, Meilisearch/Elasticsearch/Typesense/Database drivers |
| Session | `ez-php/session` | Session handler drivers (File/Database/Redis/Cache/Array), flash data, id regeneration |
| SMS | `ez-php/sms` | SMS delivery — Twilio, Vonage, Log and Null drivers |
| Storage | `ez-php/storage` | File storage abstraction, Local, S3 and GCS drivers |
| Support | `ez-php/support` | Utility classes — `Range`, `WeightedRandom`, `DailyQuota`, `CronExpression`, grid/coordinate helpers |
| Swagger UI | `ez-php/swagger-ui` | Serves Swagger UI / ReDoc docs for the OpenAPI spec |
| Tenancy | `ez-php/tenancy` | Single-database multi-tenancy — tenant resolution, tenant-scoped cache and search |
| Two-Factor | `ez-php/two-factor` | TOTP two-factor authentication, backup codes |
| Validation | `ez-php/validation` | Rule-based input validation |
| View | `ez-php/view` | PHP template engine, layouts, sections |
| View Cache | `ez-php/view-cache` | Output-caching decorator for `ez-php/view` |
| WebAuthn | `ez-php/webauthn` | WebAuthn / FIDO2 passkey authentication — registration and assertion ceremonies, attestation verification |
| WebAuthn Metadata | `ez-php/webauthn-metadata` | FIDO MDS trust-anchor lookups for WebAuthn — blob download, JWT verification, attestation chain trust decisions |
| Webhook | `ez-php/webhook` | Outgoing webhooks — HMAC-signed delivery as a retrying queue job, plus incoming signature verification middleware |
| WebSocket | `ez-php/websocket` | RFC 6455 WebSocket server (Fiber-based), opt-in permessage-deflate |
| WebSocket Client | `ez-php/websocket-client` | RFC 6455 WebSocket client — `ws://` and `wss://`, blocking API, opt-in permessage-deflate |
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
| Redis 7 | 6383 | Cache / queue backend |
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
