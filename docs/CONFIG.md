# Configuration Reference

Central reference for every `.env` variable and config key across all ez-php modules.

All config files live in `config/` and return plain PHP arrays. Values are read from the environment via `getenv()`. The config key format uses dot notation: `file.key` maps to `config/file.php` → `key`.

---

## Core

### Application — `config/app.php`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `app.name` | `APP_NAME` | string | — | Application name |
| `app.debug` | `APP_DEBUG` | bool | `false` | Enable debug mode (`true`/`false`, read via `FILTER_VALIDATE_BOOLEAN`) |
| `app.locale` | `APP_LOCALE` | string | `'en'` | Default application locale |
| `app.fallback_locale` | `APP_FALLBACK_LOCALE` | string | `'en'` | Fallback locale when a translation key is missing |
| `app.fallback_locales` | — | list\|null | `null` | Ordered fallback chain (e.g. `['de_AT', 'de', 'en']`); overrides `fallback_locale` when set |
| `app.locales` | — | list\|null | `null` | Locales `LocaleNegotiationMiddleware` may pick from `Accept-Language`; unset = `locale` plus the fallback chain |
| `app.lang_path` | — | string | `<project>/lang` | Directory holding `<locale>/*.php` translation files |
| `app.version` | `APP_VERSION` | string | `'1.0.0'` | Application version (used as the OpenAPI spec version) |
| `app.url_signing_key` | `APP_URL_SIGNING_KEY` | string | `''` | Secret for `UrlSigner` signed links; resolving `UrlSigner` without it throws. Rotating it invalidates issued links |
| — | `APP_ENV` | string | — | Deployment environment (`local`, `production`, …). Read from the process environment via `getenv()`, **not** from `config/app.php`. When it is `production`, `db:seed` and `db:setup` refuse to run without `--force`, and `ExceptionHandlerServiceProvider` passes it to `DefaultExceptionHandler`, which logs a warning when debug mode is on in production |

> `APP_DEBUG` is also read directly from the environment by `ExceptionHandlerServiceProvider::boot()`: when true, `DebugToolbarMiddleware` is added to the global middleware stack.

### Database — `config/db.php`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `db.driver` | `DB_DRIVER` | string | `'mysql'` | PDO driver (`mysql`, `sqlite`, etc.) |
| `db.host` | `DB_HOST` | string | — | Database host |
| `db.port` | `DB_PORT` | string | — | Database port |
| `db.database` | `DB_DATABASE` | string | — | Database name |
| `db.username` | `DB_USERNAME` | string | — | Database username |
| `db.password` | `DB_PASSWORD` | string | — | Database password |
| `db.testing_database` | `DB_TESTING_DATABASE` | string | — | Separate database for test runs (swapped into `DB_DATABASE` by `tests/bootstrap.php` / `MigrationBootstrap`, not by `DatabaseTestCase`) |

### Security headers — `config/security.php`

Read by the framework's `SecurityHeadersMiddleware` (register it with `$app->middleware(...)`).

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `security.headers` | — | array<string, string\|null> | `[]` | Overrides for the default security headers; `null` removes one, e.g. `'Content-Security-Policy' => "default-src 'self'"` |

### Docker host ports — `docker-compose.yml`

Read by Docker Compose only, not by any config file. Each sets the port published on the host; inside the Compose network, services keep their standard ports.

| Env var | Default | Description |
|---|---|---|
| `APP_PORT` | `8001` | App (nginx) |
| `DB_HOST_PORT` | `3308` | MySQL |
| `REDIS_PORT` | `6383` | Redis; the app's own connections use `*_REDIS_PORT` (`6379`) |
| `MAIL_WEB_PORT` | `8025` | Mailpit web UI |

`MAIL_PORT` (see `mail.port`) also sets Mailpit's published SMTP port. `MEILISEARCH_PORT` (`7702`) applies only once the opt-in Meilisearch service is uncommented.

---

## Optional Modules

### Auth (JWT) — `config/auth.php`

```php
<?php

declare(strict_types=1);

return [
    'jwt' => [
        'secret' => getenv('JWT_SECRET') ?: '',
        'ttl' => (int) (getenv('JWT_TTL') ?: 3600),
    ],
];
```

`ez-php/auth`'s `JwtServiceProvider` reads these keys through `ConfigInterface`. An unset or empty key falls back to the environment variable, so applications created before `config/auth.php` existed keep working unchanged.

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `auth.jwt.secret` | `JWT_SECRET` | string | — | **Required** when `JwtManager` is resolved: HMAC signing key of at least 32 bytes (`JwtManager::MIN_SECRET_BYTES`), e.g. `bin2hex(random_bytes(32))`. A shorter or empty value makes resolving `JwtManager` throw `InvalidArgumentException` |
| `auth.jwt.ttl` | `JWT_TTL` | int | `3600` | Token lifetime in seconds |

### Cache — `config/cache.php`

Package: `ez-php/cache`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `cache.driver` | `CACHE_DRIVER` | string | `'array'` | Driver: `array`, `file`, `redis`, `memcached`, `database`, `apcu` (ext-apcu; CLI needs `apc.enable_cli=1`) |
| `cache.file_path` | `CACHE_PATH` | string | `sys_get_temp_dir().'/ez-cache'` | Directory for the file cache driver |
| `cache.prefix` | `CACHE_PREFIX` | string | `''` | Non-empty: wraps the driver in `PrefixedCache` — every key, lock and tag list gets this prefix (`flush()` still empties the whole store) |
| `cache.redis.host` | `CACHE_REDIS_HOST` | string | `'127.0.0.1'` | Redis host |
| `cache.redis.port` | `CACHE_REDIS_PORT` | int | `6379` | Redis port |
| `cache.redis.database` | `CACHE_REDIS_DB` | int | `0` | Redis database index |
| `cache.memcached.host` | `CACHE_MEMCACHED_HOST` | string | `'127.0.0.1'` | Memcached host |
| `cache.memcached.port` | `CACHE_MEMCACHED_PORT` | int | `11211` | Memcached port |
| `cache.memcached.weight` | `CACHE_MEMCACHED_WEIGHT` | int | `0` | Server weight |
| `cache.database.table` | `CACHE_DB_TABLE` | string | `'cache'` | Entry table of the database driver (auto-created) |
| `cache.database.lock_table` | `CACHE_DB_LOCK_TABLE` | string | `'cache_locks'` | Lock table of the database driver (auto-created) |

Cache values must be `null`, scalars or arrays — every driver rejects objects.

### Mail — `config/mail.php`

Package: `ez-php/mail`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `mail.driver` | `MAIL_DRIVER` | string | `'null'` | Driver: `smtp`, `mailgun`, `sendgrid`, `postmark`, `ses`, `log`, `null` |
| `mail.from_address` | `MAIL_FROM_ADDRESS` | string | `''` | Default sender address (all drivers) |
| `mail.from_name` | `MAIL_FROM_NAME` | string | `''` | Default sender display name (all drivers) |
| `mail.log_path` | `MAIL_LOG_PATH` | string | `''` | Log file path (log driver only) |
| `mail.timeout` | `MAIL_TIMEOUT` | int | `30` | Network timeout in seconds (smtp, mailgun, sendgrid, postmark, ses); HTTP drivers also fail a connect after 10 s |

**SMTP driver** (`MAIL_DRIVER=smtp`):

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `mail.host` | `MAIL_HOST` | string | `'127.0.0.1'` | SMTP host |
| `mail.port` | `MAIL_PORT` | int | `1025` | SMTP port |
| `mail.username` | `MAIL_USERNAME` | string | `''` | SMTP username (empty = no auth) |
| `mail.password` | `MAIL_PASSWORD` | string | `''` | SMTP password |
| `mail.encryption` | `MAIL_ENCRYPTION` | string | `'none'` | Encryption: `tls`, `ssl`, `none` |

**Mailgun driver** (`MAIL_DRIVER=mailgun`) — add to `config/mail.php`:

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `mail.mailgun_domain` | `MAILGUN_DOMAIN` | string | — | Mailgun sending domain |
| `mail.mailgun_secret` | `MAILGUN_SECRET` | string | — | Mailgun API key |
| `mail.mailgun_region` | `MAILGUN_REGION` | string | `'us'` | API region: `us` or `eu` |

**SendGrid driver** (`MAIL_DRIVER=sendgrid`) — add to `config/mail.php`:

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `mail.sendgrid_api_key` | `SENDGRID_API_KEY` | string | — | SendGrid v3 API key |
| `mail.sendgrid_region` | `SENDGRID_REGION` | string | `'us'` | API region: `us` or `eu` (`api.eu.sendgrid.com`, EU data residency) |

**Postmark driver** (`MAIL_DRIVER=postmark`) — add to `config/mail.php`:

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `mail.postmark_token` | `POSTMARK_TOKEN` | string | — | Postmark server token |

**Amazon SES driver** (`MAIL_DRIVER=ses`) — add to `config/mail.php`:

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `mail.ses_key` | `SES_ACCESS_KEY_ID` | string | — | AWS access key id with `ses:SendEmail` |
| `mail.ses_secret` | `SES_SECRET_ACCESS_KEY` | string | — | AWS secret access key |
| `mail.ses_region` | `SES_REGION` | string | `'us-east-1'` | AWS region of the SES identity |

### Queue — `config/queue.php`

Package: `ez-php/queue`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `queue.driver` | `QUEUE_DRIVER` | string | `'database'` | Driver: `database`, `redis`, `memory` (in-process; tests only) |
| `queue.redis.host` | `QUEUE_REDIS_HOST` | string | `'127.0.0.1'` | Redis host |
| `queue.redis.port` | `QUEUE_REDIS_PORT` | int | `6379` | Redis port |
| `queue.redis.database` | `QUEUE_REDIS_DB` | int | `0` | Redis database index |

### Rate Limiter — `config/rate_limiter.php`

Package: `ez-php/rate-limiter`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `rate_limiter.driver` | `RATE_LIMITER_DRIVER` | string | `'array'` | Driver: `array`, `file`, `redis`, `cache` |
| `rate_limiter.file.path` | `RATE_LIMITER_FILE_PATH` | string | `sys_get_temp_dir().'/ez-php-rate-limiter'` | Counter directory (`file` driver only) |
| `rate_limiter.redis.host` | `RATE_LIMITER_REDIS_HOST` | string | `'127.0.0.1'` | Redis host |
| `rate_limiter.redis.port` | `RATE_LIMITER_REDIS_PORT` | int | `6379` | Redis port |
| `rate_limiter.redis.database` | `RATE_LIMITER_REDIS_DB` | int | `0` | Redis database index |
| `rate_limiter.trusted_proxies` | `RATE_LIMITER_TRUSTED_PROXIES` | string\|list | `''` | Reverse-proxy IPs (comma-separated) whose `X-Forwarded-For` `ThrottleMiddleware` honours |

### Scheduler — `config/scheduler.php`

Package: `ez-php/scheduler`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `scheduler.mutex` | `SCHEDULER_MUTEX` | string | `'file'` | Mutex for `withoutOverlapping()` entries: `file`, `database`, `database_expiry`, `redis`, `cache` (needs a bound `ez-php/cache` `CacheInterface`), `none` |
| `scheduler.ttl` | `SCHEDULER_TTL` | int | `3600` | Lock lifetime in seconds (`database_expiry`, `redis`, `cache`) |
| `scheduler.file.path` | `SCHEDULER_LOCK_PATH` | string | `sys_get_temp_dir().'/ez-scheduler-locks'` | Lock-file directory (`file` mutex) |
| `scheduler.redis.host` | `SCHEDULER_REDIS_HOST` | string | `'127.0.0.1'` | Redis host (`redis` mutex) |
| `scheduler.redis.port` | `SCHEDULER_REDIS_PORT` | int | `6379` | Redis port |
| `scheduler.redis.database` | `SCHEDULER_REDIS_DB` | int | `0` | Redis database index |

Entries are registered by the application (`$app->make(Scheduler::class)->command(...)` in a provider's `boot()`); run `php ez scheduler:run` every minute from cron.

### Logging — `config/logging.php`

Package: `ez-php/logging`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `logging.driver` | `LOG_DRIVER` | string | `'file'` | Driver: `file`, `stdout`, `syslog`, `null`, `json`, `stack` |
| `logging.path` | `LOG_PATH` | string | `''` | Log directory for the `file` driver (defaults to `storage/logs` when empty) |
| `logging.max_bytes` | `LOG_MAX_BYTES` | int | `0` | Max file size in bytes before rotation; `0` = no size limit |
| `logging.min_level` | `LOG_LEVEL` | string | `''` | Minimum level to write: `debug`, `info`, `warning`, `error`, `critical`; empty = all |
| `logging.syslog.ident` | `LOG_SYSLOG_IDENT` | string | `'ez-php'` | Program name of `syslog` entries |
| `logging.syslog.facility` | `LOG_SYSLOG_FACILITY` | string | `'user'` | Syslog facility: `user`, `daemon`, `auth`, `local0` … `local7` |
| `logging.json_inner` | `LOG_JSON_INNER` | string | `'stdout'` | Inner driver for the `json` driver: `file`, `stdout`, `syslog`, `null` |
| `logging.stack` | — | array | `['file','stdout']` | Drivers for the `stack` driver; configured in `config/logging.php` directly |

**Driver overview:**

| Driver | Description |
|---|---|
| `file` | Appends JSON-or-text lines to `LOG_PATH/app-YYYY-MM-DD.log`; date-rotated automatically |
| `stdout` | `debug`/`info`/`warning` → stdout; `error`/`critical` → stderr |
| `syslog` | System logger (syslog/journald) via `openlog()`/`syslog()`; level → `LOG_*` priority |
| `null` | Discards all entries silently (useful in tests and CI) |
| `json` | Serialises each entry as a JSON object and forwards to `LOG_JSON_INNER` |
| `stack` | Fans a single call out to multiple drivers listed in `logging.stack` |

**Wrapping with `MinLevelDriver`:**

When `LOG_LEVEL` is set to a non-empty value, `LogServiceProvider` automatically wraps the configured driver with `MinLevelDriver`. Entries below the minimum are dropped before reaching any driver.

**`RequestContextMiddleware`:**

Registers request-scoped context (`request_id`, `ip`, `method`, `path`, optional `user_id`) into the `Log` facade for the lifetime of each HTTP request. Register it as global middleware:

```php
$app->middleware(RequestContextMiddleware::class);
```

### View — `config/view.php`

Package: `ez-php/view`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `view.path` | `VIEW_PATH` | string | `'resources/views'` | Template directory path |

### Broadcast — `config/broadcast.php`

Package: `ez-php/broadcast`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `broadcast.driver` | `BROADCAST_DRIVER` | string | `'null'` | Driver: `null`, `log`, `array`, `redis` |
| `broadcast.log_path` | `BROADCAST_LOG_PATH` | string | `''` | Log file path (log driver only) |
| `broadcast.redis.host` | `BROADCAST_REDIS_HOST` | string | `'127.0.0.1'` | Redis host (redis driver only) |
| `broadcast.redis.port` | `BROADCAST_REDIS_PORT` | int | `6379` | Redis port |
| `broadcast.redis.database` | `BROADCAST_REDIS_DB` | int | `0` | Redis database index |

### Search — `config/search.php`

Package: `ez-php/search`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `search.driver` | `SEARCH_DRIVER` | string | `'null'` | Driver: `null`, `meilisearch`, `elasticsearch`, `typesense`, `database` |

**Meilisearch** (`SEARCH_DRIVER=meilisearch`):

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `search.meilisearch.host` | `MEILISEARCH_HOST` | string | `'http://meilisearch:7700'` | Meilisearch server URL |
| `search.meilisearch.key` | `MEILISEARCH_KEY` | string | `''` | Meilisearch API key |

**Elasticsearch** (`SEARCH_DRIVER=elasticsearch`):

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `search.elasticsearch.host` | `ELASTICSEARCH_HOST` | string | `'http://elasticsearch:9200'` | Elasticsearch server URL |
| `search.elasticsearch.user` | `ELASTICSEARCH_USER` | string | `''` | Basic auth username |
| `search.elasticsearch.password` | `ELASTICSEARCH_PASSWORD` | string | `''` | Basic auth password |

**Typesense** (`SEARCH_DRIVER=typesense`) — add to `config/search.php`:

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `search.typesense.host` | `TYPESENSE_HOST` | string | `'http://typesense:8108'` | Typesense server URL |
| `search.typesense.key` | `TYPESENSE_KEY` | string | `''` | Typesense API key |

**Database** (`SEARCH_DRIVER=database`) — full-text search on the application's own database (MySQL `FULLTEXT`, SQLite FTS5; resolves `DatabaseInterface`):

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `search.database.table` | `SEARCH_DB_TABLE` | string | `'search_documents'` | Documents table, created on first use; `[A-Za-z0-9_]` only |

### Storage — `config/storage.php`

Package: `ez-php/storage` — create this file in your application's `config/` directory.

```php
<?php
declare(strict_types=1);
return [
    'driver' => getenv('STORAGE_DRIVER') ?: 'local',
    'local' => [
        'root' => getenv('STORAGE_ROOT') ?: '',
        'url'  => getenv('STORAGE_URL') ?: '',
    ],
    's3' => [
        'key'        => getenv('AWS_ACCESS_KEY_ID') ?: '',
        'secret'     => getenv('AWS_SECRET_ACCESS_KEY') ?: '',
        'region'     => getenv('AWS_DEFAULT_REGION') ?: 'us-east-1',
        'bucket'     => getenv('AWS_BUCKET') ?: '',
        'endpoint'   => getenv('AWS_ENDPOINT') ?: null,
        'url'        => getenv('AWS_URL') ?: null,
        'url_expiry' => (int) (getenv('STORAGE_S3_URL_EXPIRY') ?: 3600),
    ],
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `storage.driver` | `STORAGE_DRIVER` | string | `'local'` | Driver: `local`, `s3`, `gcs`, `memory` (in-process; tests only) |
| `storage.local.root` | `STORAGE_ROOT` | string | `''` | Absolute path to the storage root directory |
| `storage.local.url` | `STORAGE_URL` | string | `''` | Public base URL for local files (e.g. CDN prefix) |
| `storage.s3.key` | `AWS_ACCESS_KEY_ID` | string | — | AWS / S3-compatible access key ID |
| `storage.s3.secret` | `AWS_SECRET_ACCESS_KEY` | string | — | AWS / S3-compatible secret access key |
| `storage.s3.region` | `AWS_DEFAULT_REGION` | string | `'us-east-1'` | AWS region |
| `storage.s3.bucket` | `AWS_BUCKET` | string | — | S3 bucket name |
| `storage.s3.endpoint` | `AWS_ENDPOINT` | string\|null | `null` | Custom endpoint for MinIO, R2, Spaces, etc.; an explicit `http://` scheme is kept (local MinIO without TLS), anything else is reached over HTTPS |
| `storage.s3.url` | `AWS_URL` | string\|null | `null` | CDN base URL; overrides presigned URLs when set |
| `storage.s3.url_expiry` | `STORAGE_S3_URL_EXPIRY` | int | `3600` | Pre-signed URL lifetime in seconds |
| `storage.s3.multipart_part_size` | `STORAGE_S3_MULTIPART_PART_SIZE` | int | `8388608` | Part size for multipart `putStream()` uploads (≥ 5 MiB) |
| `storage.gcs.bucket` | `GCS_BUCKET` | string | `''` | Google Cloud Storage bucket |
| `storage.gcs.access_token` | `GCS_ACCESS_TOKEN` | string | `''` | OAuth2 Bearer token (refreshing it is the application's job) |
| `storage.gcs.url` | `GCS_URL` | string\|null | `null` | CDN/public base URL for `url()` (wins over signing) |
| `storage.gcs.client_email` | `GCS_CLIENT_EMAIL` | string\|null | `null` | Service-account email; with `private_key`, `url()` returns V4 signed URLs |
| `storage.gcs.private_key` | `GCS_PRIVATE_KEY` | string\|null | `null` | PEM RSA key of that service account (literal `\n` sequences are converted); requires ext-openssl |
| `storage.gcs.url_expiry` | `GCS_URL_EXPIRY` | int | `3600` | Signed-URL lifetime in seconds (max 604800 = 7 days) |
| `storage.gcs.endpoint` | `GCS_ENDPOINT` | string\|null | `null` | API base URL instead of `https://storage.googleapis.com` (e.g. a local fake-gcs-server); also the base of public object URLs — signed URLs always target Google |

### AI — `config/ai.php`

Package: `ez-php/ai`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `ai.driver` | `AI_DRIVER` | string | `'null'` | Driver: `openai`, `anthropic`, `gemini`, `mistral`, `grok`, `log`, `null` |
| `ai.embedding_driver` | `AI_EMBEDDING_DRIVER` | string | `'null'` | Embeddings driver, independent of `ai.driver`: `openai`, `gemini`, `null` |
| `ai.stream_idle_timeout` | `AI_STREAM_IDLE_TIMEOUT` | int | `120` | Seconds a streamed completion may send nothing before it fails (no total limit) |
| `ai.openai.api_key` | `OPENAI_API_KEY` | string | `''` | OpenAI API key |
| `ai.openai.model` | `OPENAI_MODEL` | string | `'gpt-4o-mini'` | OpenAI model name |
| `ai.openai.base_url` | `OPENAI_BASE_URL` | string | `'https://api.openai.com'` | OpenAI API base URL |
| `ai.anthropic.api_key` | `ANTHROPIC_API_KEY` | string | `''` | Anthropic API key |
| `ai.anthropic.model` | `ANTHROPIC_MODEL` | string | `'claude-sonnet-4-6'` | Anthropic model name |
| `ai.anthropic.api_version` | `ANTHROPIC_API_VERSION` | string | `'2023-06-01'` | Anthropic API version header |
| `ai.gemini.api_key` | `GEMINI_API_KEY` | string | `''` | Google Gemini API key |
| `ai.gemini.model` | `GEMINI_MODEL` | string | `'gemini-2.0-flash'` | Gemini model name |
| `ai.mistral.api_key` | `MISTRAL_API_KEY` | string | `''` | Mistral API key |
| `ai.mistral.model` | `MISTRAL_MODEL` | string | `'mistral-small-latest'` | Mistral model name |
| `ai.mistral.base_url` | `MISTRAL_BASE_URL` | string | `'https://api.mistral.ai'` | Mistral API base URL |
| `ai.grok.api_key` | `GROK_API_KEY` | string | `''` | Grok (xAI) API key |
| `ai.grok.model` | `GROK_MODEL` | string | `'grok-3-mini'` | Grok model name |
| `ai.grok.base_url` | `GROK_BASE_URL` | string | `'https://api.x.ai'` | Grok API base URL |
| `ai.log.inner_driver` | `AI_LOG_INNER_DRIVER` | string | `'null'` | Inner driver wrapped by the `log` driver |

### Events — `config/events.php`

Package: `ez-php/events`

Not env-backed — maps event class-strings directly to arrays of listener class-strings. `EventServiceProvider` resolves each listener via the container (autowiring supported) and registers it on boot.

| Config key | Type | Default | Description |
|---|---|---|---|
| `events.listeners` | `array<class-string, list<class-string>>` | `[]` | Event class → listener classes map |

```php
return [
    'listeners' => [
        App\Events\UserCreated::class => [
            App\Listeners\SendWelcomeEmail::class,
        ],
    ],
];
```

### Health — `config/health.php`

Package: `ez-php/health` — only required when using the Redis, OPcache or disk-space probes, or to override `expose_messages`.

```php
<?php

declare(strict_types=1);

return [
    // Redis probe connection. Own variables (like CACHE_REDIS_*), not REDIS_PORT:
    // in .env.example REDIS_PORT is the host-published port, while the probe
    // connects from inside the container.
    'redis' => [
        'host' => getenv('HEALTH_REDIS_HOST') ?: '',
        'port' => (int) (getenv('HEALTH_REDIS_PORT') ?: 6379),
    ],
    'opcache' => [
        // Adds an OPcache probe (memory/interned-string/key usage) to /health.
        'enabled' => filter_var(getenv('HEALTH_OPCACHE_ENABLED'), FILTER_VALIDATE_BOOLEAN),
    ],
    // One disk-space probe per path (e.g. the storage directory); empty = none.
    // DEGRADED below degraded_percent free, UNHEALTHY below unhealthy_percent free.
    'disk' => [
        'paths' => array_values(array_filter(explode(',', getenv('HEALTH_DISK_PATHS') ?: ''))),
        'degraded_percent' => (float) (getenv('HEALTH_DISK_DEGRADED_PERCENT') ?: 10),
        'unhealthy_percent' => (float) (getenv('HEALTH_DISK_UNHEALTHY_PERCENT') ?: 5),
    ],
    // Route answering 200 without running a probe, for orchestrator liveness checks; empty = none.
    'liveness_path' => getenv('HEALTH_LIVENESS_PATH') ?: '',
    // Raw exception messages of failing probes in the public /health JSON (PDO user/host,
    // internal URLs). Unset: follow app.debug; failing probes then read "Check failed".
    'expose_messages' => getenv('HEALTH_EXPOSE_MESSAGES') === false || getenv('HEALTH_EXPOSE_MESSAGES') === ''
        ? null
        : filter_var(getenv('HEALTH_EXPOSE_MESSAGES'), FILTER_VALIDATE_BOOLEAN),
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `health.redis.host` | `HEALTH_REDIS_HOST` | string | `''` | Redis host for the Redis probe; empty or absent = no Redis probe. Once set, the probe is always registered and reports `unhealthy` while Redis is unreachable (before 2.6.5 an unreachable Redis silently dropped the probe). Previously read `REDIS_HOST`/`REDIS_PORT` — rename them in existing `.env` files; `REDIS_PORT` in the template is the host-published port, not the in-container one |
| `health.redis.port` | `HEALTH_REDIS_PORT` | int | `6379` | Redis port for the Redis probe (in-container port) |
| `health.opcache.enabled` | `HEALTH_OPCACHE_ENABLED` | bool | `false` | Add the OPcache probe |
| `health.disk.paths` | `HEALTH_DISK_PATHS` | list | `[]` | Paths whose filesystem free space is probed (env: comma-separated); one `DiskSpaceProbe` per path, none when empty |
| `health.disk.degraded_percent` | `HEALTH_DISK_DEGRADED_PERCENT` | float | `10` | Free share (%) below which a disk probe reports DEGRADED |
| `health.disk.unhealthy_percent` | `HEALTH_DISK_UNHEALTHY_PERCENT` | float | `5` | Free share (%) below which a disk probe reports UNHEALTHY |
| `health.liveness_path` | `HEALTH_LIVENESS_PATH` | string | `''` | Path of a route answering 200 without running a probe, for liveness checks; empty = no route |
| `health.expose_messages` | `HEALTH_EXPOSE_MESSAGES` | bool\|null | `null` (= `app.debug`) | Show failing probes' raw exception messages in the `/health` JSON; otherwise they read `Degraded` / `Check failed` |

### Feature Flags — `config/flags.php`

Package: `ez-php/feature-flags` — ships with the template.

```php
<?php
declare(strict_types=1);
return [
    'driver' => getenv('FLAGS_DRIVER') ?: 'file',
    'file' => getenv('FLAGS_FILE') ?: 'flags.php',
    'rollouts' => [],

    // Seconds a flag answer is cached through ez-php/cache (CachedDriver); 0 = no cache.
    'cache_ttl' => (int) (getenv('FLAGS_CACHE_TTL') ?: 0),
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `flags.driver` | `FLAGS_DRIVER` | string | `'file'` | Driver: `file`, `database`, `redis`, `array` (empty, in-memory; CI/tests) |
| `flags.file` | `FLAGS_FILE` | string | `'flags.php'` | Path to the PHP flags definition file (file driver only) |
| `flags.redis.host` | `FLAGS_REDIS_HOST` | string | `'127.0.0.1'` | Redis host (redis driver only) |
| `flags.redis.port` | `FLAGS_REDIS_PORT` | int | `6379` | Redis port |
| `flags.redis.database` | `FLAGS_REDIS_DB` | int | `0` | Redis database index |
| `flags.cache_ttl` | `FLAGS_CACHE_TTL` | int | `0` | Seconds flag answers are cached through `ez-php/cache` (`CachedDriver`, needs a bound `CacheInterface`); `0` = every check reads the store. Call `CachedDriver::forget()` after changing a flag to see it before the TTL runs out |
| `flags.rollouts` | — | array | `[]` | Percentage rollouts, flag name => 0–100; `Flag::enabledFor()` enables a stable slice of contexts (crc32 bucket) and the value replaces the stored flag |

The config key is `flags.driver`, not `flags.flags.driver`: the file's basename already supplies the `flags` namespace, so the array is flat.

**Flag definitions** (file driver) — `flags.php` in the application root, shipped empty:

```php
<?php
return [
    'new-checkout' => true,
    'dark-mode'    => false,
];
```

Keep this file out of `config/`. Everything in `config/` is loaded as a config namespace, so a definitions file at `config/flags.php` would be the driver's own config file — `Flag::enabled('driver')` and `Flag::enabled('file')` would return `true` and every real flag `false`.

### OpenAPI — `config/openapi.php`

Package: `ez-php/openapi` — ships with the template.

```php
<?php
declare(strict_types=1);
return [
    'endpoint'   => getenv('OPENAPI_ENDPOINT') ?: '/openapi.json',
    'components' => [],
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `openapi.endpoint` | `OPENAPI_ENDPOINT` | string | `'/openapi.json'` | URI the generated spec is served from |
| `openapi.version` | `OPENAPI_VERSION` | string | `'3.0'` | `3.0` or `3.1`; for 3.0, JSON Schema 2020-12 constructs in component schemas are converted (nullable, example, …) |
| `openapi.components` | — | array | `[]` | Reusable component objects merged into the spec |
| `openapi.schema_classes` | — | list | `[]` | Classes whose JSON Schema (`ez-php/json-schema`) is generated into `components.schemas` |

The spec's title and version come from `app.name` and `app.version`.

**Component schemas** — the module never derives schemas from your classes.
`#[ApiResponse(200, User::class)]` emits a `$ref` to `#/components/schemas/User`;
that reference resolves only if you declare the schema yourself:

```php
'components' => [
    'schemas' => [
        'User' => [
            'type' => 'object',
            'properties' => [
                'id'    => ['type' => 'integer'],
                'email' => ['type' => 'string', 'format' => 'email'],
            ],
        ],
    ],
],
```

The `components` key is omitted from the generated spec while this array is empty.

---

### AsyncAPI — `config/asyncapi.php`

Package: `ez-php/asyncapi`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `asyncapi.endpoint` | `ASYNCAPI_ENDPOINT` | string | `'/asyncapi.json'` | URI the generated AsyncAPI document is served from |
| `asyncapi.classes` | — | list<class-string> | `[]` | Message classes (with `#[Channel]` + `#[Message]`) to document; nothing else is discovered |
| `asyncapi.servers` | — | array | `[]` | AsyncAPI Server Objects keyed by name, e.g. `['production' => ['host' => 'ws.example.com', 'protocol' => 'wss']]` |

---

### AsyncAPI UI — `config/asyncapi-ui.php`

Package: `ez-php/asyncapi-ui`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `asyncapi-ui.endpoint` | `ASYNCAPI_UI_ENDPOINT` | string | `'/asyncapi-docs'` | Path of the viewer page; empty registers no route |
| `asyncapi-ui.document_url` | `ASYNCAPI_UI_DOCUMENT_URL` | string | `''` | URL the page loads the AsyncAPI document from; empty uses `asyncapi.endpoint`, else `/asyncapi.json` |

The page title comes from `app.name`.

---

### OpenTelemetry — `config/otel.php`

Package: `ez-php/otel`

```php
<?php
declare(strict_types=1);
return [
    'exporter' => getenv('OTEL_EXPORTER') ?: null,
    'endpoint' => getenv('OTEL_EXPORTER_OTLP_ENDPOINT') ?: null,
    'service_name' => getenv('OTEL_SERVICE_NAME') ?: 'ez-php-app',
    'sample_ratio' => is_numeric(getenv('OTEL_SAMPLE_RATIO')) ? (float) getenv('OTEL_SAMPLE_RATIO') : 1.0,
    'batch_size' => is_numeric(getenv('OTEL_BATCH_SIZE')) ? (int) getenv('OTEL_BATCH_SIZE') : 512,
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `otel.exporter` | `OTEL_EXPORTER` | string\|null | `'otlp'` if an endpoint is set, else `'null'` | `otlp`, `memory`, or anything else to discard spans |
| `otel.endpoint` | `OTEL_EXPORTER_OTLP_ENDPOINT` | string\|null | `null` | Full OTLP/HTTP traces URL, e.g. `http://localhost:4318/v1/traces` |
| `otel.service_name` | `OTEL_SERVICE_NAME` | string | `'ez-php-app'` | `service.name` resource attribute |
| `otel.sample_ratio` | `OTEL_SAMPLE_RATIO` | float | `1.0` | Share of traces exported (OTLP only); decided per trace ID, so a trace is kept or dropped whole |
| `otel.batch_size` | `OTEL_BATCH_SIZE` | int | `512` | Spans per OTLP export call; the rest is sent at the end of the request. `0` = one call per span |

### Sessions — `config/session.php`

Package: `ez-php/session`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `session.driver` | `SESSION_DRIVER` | string | `'file'` | Handler: `file`, `database`, `redis`, `cache` (the `ez-php/cache` store), `array` |
| `session.file.path` | `SESSION_FILE_PATH` | string | `sys_get_temp_dir() . '/ez-session'` | Directory for the `file` driver |
| `session.database.table` | `SESSION_TABLE` | string | `'sessions'` | Table for the `database` driver; letters, digits and `_` only |
| `session.redis.host` | `SESSION_REDIS_HOST` | string | `'127.0.0.1'` | Redis host |
| `session.redis.port` | `SESSION_REDIS_PORT` | int | `6379` | Redis port |
| `session.redis.database` | `SESSION_REDIS_DATABASE` | int | `0` | Redis database index |
| `session.redis.ttl` | `SESSION_REDIS_TTL` | int | `1440` | Redis key TTL in seconds (the `redis` driver's idle lifetime); falls back to `SESSION_IDLE_LIFETIME` when unset |
| `session.cache.prefix` | `SESSION_CACHE_PREFIX` | string | `'session:'` | Key prefix of the `cache` driver |
| `session.idle_lifetime` | `SESSION_IDLE_LIFETIME` | int | php.ini `session.gc_maxlifetime` (PHP default `1440`) | Server-side idle lifetime in seconds: the `file`/`database` drivers treat a session not written for longer as gone (independent of PHP's probabilistic GC), and `StartSessionMiddleware` sets `gc_maxlifetime` to it; `0` disables the check (the `redis`/`cache` drivers then use the longer of `session.cookie.lifetime` and php.ini's `session.gc_maxlifetime` as entry TTL, never "no expiry"). Not the cookie lifetime (`session.cookie.lifetime`) |
| `session.regenerate_interval` | `SESSION_REGENERATE_INTERVAL` | int | `0` | Seconds between session-id regenerations; `0` disables |
| `session.strict_mode` | `SESSION_STRICT_MODE` | bool | `true` | Never adopt a client-chosen session id (fixation protection) |
| `session.cookie.name` | `SESSION_COOKIE` | string | `''` | Cookie name; empty keeps PHP's `session.name` |
| `session.cookie.secure` | `SESSION_SECURE_COOKIE` | bool\|null | `null` | `null`/unset = Secure on HTTPS requests; `true` behind a TLS-terminating proxy |
| `session.cookie.httponly` | `SESSION_HTTP_ONLY` | bool | `true` | Hide the cookie from JavaScript |
| `session.cookie.samesite` | `SESSION_SAME_SITE` | string | `'Lax'` | `Lax`, `Strict` or `None` |
| `session.cookie.lifetime` | `SESSION_LIFETIME` | int | `0` | Cookie lifetime in seconds; `0` = browser session |
| `session.cookie.path` | `SESSION_PATH` | string | `'/'` | Cookie path |
| `session.cookie.domain` | `SESSION_DOMAIN` | string | `''` | Cookie domain |

---

### Webhooks — `config/webhook.php`

Package: `ez-php/webhook`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `webhook.secret` | `WEBHOOK_SECRET` | string | `''` | HMAC secret used to sign outgoing and verify incoming webhooks |
| `webhook.signature_header` | `WEBHOOK_SIGNATURE_HEADER` | string | `'X-Webhook-Signature'` | Header carrying the signature |
| `webhook.queue` | `WEBHOOK_QUEUE` | string | `'default'` | Queue that delivery jobs are pushed to |
| `webhook.timestamped` | `WEBHOOK_TIMESTAMPED` | bool | `false` | Sender: add `X-Webhook-Timestamp` and sign `"{timestamp}.{body}"` (replay protection) |
| `webhook.tolerance` | `WEBHOOK_TOLERANCE` | int | `0` | Receiver: max clock difference in seconds for timestamped signatures; `0` accepts plain signatures only |

---

### AI Media — `config/ai_media.php`

Package: `ez-php/ai-media`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `ai_media.image_driver` | `AI_MEDIA_IMAGE_DRIVER` | string | `'null'` | Image generation: `openai`, `gemini`, `null` |
| `ai_media.transcription_driver` | `AI_MEDIA_TRANSCRIPTION_DRIVER` | string | `'null'` | Audio transcription: `openai`, `gemini`, `null` |
| `ai_media.speech_driver` | `AI_MEDIA_SPEECH_DRIVER` | string | `'null'` | Text-to-speech: `openai`, `gemini`, `null` |
| `ai_media.openai.api_key` | `OPENAI_API_KEY` | string | `''` | OpenAI API key |
| `ai_media.openai.base_url` | `OPENAI_BASE_URL` | string | `'https://api.openai.com'` | OpenAI API base URL |
| `ai_media.openai.image_model` | `AI_MEDIA_OPENAI_IMAGE_MODEL` | string | `'dall-e-3'` | OpenAI image model |
| `ai_media.openai.transcription_model` | `AI_MEDIA_OPENAI_TRANSCRIPTION_MODEL` | string | `'whisper-1'` | OpenAI transcription model |
| `ai_media.openai.speech_model` | `AI_MEDIA_OPENAI_SPEECH_MODEL` | string | `'tts-1'` | OpenAI speech model |
| `ai_media.gemini.api_key` | `GEMINI_API_KEY` | string | `''` | Gemini API key |
| `ai_media.gemini.base_url` | `AI_MEDIA_GEMINI_BASE_URL` | string | `'https://generativelanguage.googleapis.com'` | Gemini API base URL |
| `ai_media.gemini.image_model` | `AI_MEDIA_GEMINI_IMAGE_MODEL` | string | `'imagen-3.0-generate-002'` | Gemini image model |
| `ai_media.gemini.transcription_model` | `AI_MEDIA_GEMINI_TRANSCRIPTION_MODEL` | string | `'gemini-2.0-flash'` | Gemini transcription model |
| `ai_media.gemini.speech_model` | `AI_MEDIA_GEMINI_SPEECH_MODEL` | string | `'gemini-2.5-flash-preview-tts'` | Gemini speech model |

---

### GraphQL — `config/graphql.php`

Package: `ez-php/graphql`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `graphql.endpoint` | `GRAPHQL_ENDPOINT` | string | `'/graphql'` | Route the endpoint is registered on |
| `graphql.max_query_depth` | `GRAPHQL_MAX_QUERY_DEPTH` | int | `15` | Maximum query nesting depth |
| `graphql.max_query_complexity` | `GRAPHQL_MAX_QUERY_COMPLEXITY` | int | `200` | Maximum query complexity score |
| `graphql.persisted_queries` | `GRAPHQL_PERSISTED_QUERIES` | bool | `false` | Enable automatic persisted queries (needs a bound `CacheInterface`) |
| `graphql.persisted_queries_ttl` | `GRAPHQL_PERSISTED_QUERIES_TTL` | int | `0` | Persisted-query cache TTL in seconds; `0` = forever |

Error detail follows `app.debug`.

---

### Media — `config/media.php`

Package: `ez-php/media`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `media.driver` | `MEDIA_DRIVER` | string | `'gd'` | Image backend: `gd` (`ext-gd`) or `imagick` (`ext-imagick`) |

---

### Push — `config/push.php`

Package: `ez-php/push`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `push.driver` | `PUSH_DRIVER` | string | `'null'` | Driver: `apns`, `fcm`, `webpush`, `array` (in-memory; tests), `null` |
| `push.apns.private_key` | `PUSH_APNS_PRIVATE_KEY` | string | `''` | APNs `.p8` key contents |
| `push.apns.key_id` | `PUSH_APNS_KEY_ID` | string | `''` | APNs key ID |
| `push.apns.team_id` | `PUSH_APNS_TEAM_ID` | string | `''` | Apple team ID |
| `push.apns.bundle_id` | `PUSH_APNS_BUNDLE_ID` | string | `''` | App bundle ID (`apns-topic`) |
| `push.apns.sandbox` | `PUSH_APNS_SANDBOX` | bool | `false` | Use the APNs sandbox endpoint |
| `push.fcm.private_key` | `PUSH_FCM_PRIVATE_KEY` | string | `''` | Service-account private key |
| `push.fcm.project_id` | `PUSH_FCM_PROJECT_ID` | string | `''` | Firebase project ID |
| `push.fcm.client_email` | `PUSH_FCM_CLIENT_EMAIL` | string | `''` | Service-account client email |
| `push.webpush.private_key` | `PUSH_WEBPUSH_PRIVATE_KEY` | string | `''` | VAPID private key |
| `push.webpush.subject` | `PUSH_WEBPUSH_SUBJECT` | string | `''` | VAPID subject (`mailto:` or URL) |
| `push.webpush.ttl` | `PUSH_WEBPUSH_TTL` | int | `86400` | Message TTL in seconds |

---

### Encryption — `config/encryption.php`

Package: `ez-php/encryption`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `encryption.key` | `ENCRYPTION_KEY` | string | `''` | Current key, `base64:` + 32 random bytes (`ez encryption:key`); required on first encrypt/decrypt |
| `encryption.previous_keys` | `ENCRYPTION_PREVIOUS_KEYS` | list\|string | `''` | Decrypt-only keys after a rotation, comma-separated |
| `encryption.cookie_except` | — | list | `['XSRF-TOKEN']` | Cookies `EncryptedCookieMiddleware` leaves unencrypted (JavaScript-readable ones) |

---

### Tenancy — `config/tenancy.php`

Package: `ez-php/tenancy`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `tenancy.resolver` | `TENANCY_RESOLVER` | string | `'subdomain'` | `subdomain`, `host`, `header`, `path`, or a comma-separated chain tried in order |
| `tenancy.base_domain` | `TENANCY_BASE_DOMAIN` | string | `''` | Base domain of the `subdomain` resolver (`acme.example.com` → `acme`); required by it |
| `tenancy.hosts` | — | map | `[]` | Host → tenant id for the `host` resolver (custom domains) |
| `tenancy.header` | `TENANCY_HEADER` | string | `'X-Tenant'` | Header of the `header` resolver |
| `tenancy.path_segment` | `TENANCY_PATH_SEGMENT` | int | `0` | Zero-based path segment of the `path` resolver |
| `tenancy.required` | `TENANCY_REQUIRED` | bool | `true` | `ResolveTenantMiddleware` answers 404 when no known tenant resolves; `false` continues without one |
| `tenancy.tenants` | — | map | `[]` | Tenant id → attributes for `ArrayTenantStore`; ids are DNS labels (`[a-z0-9-]`, 1–63) |
| `tenancy.cache_prefix` | `TENANCY_CACHE_PREFIX` | string | `'tenant:'` | `TenantScopedCache` key prefix, followed by `<id>:` |

---

### Mail Events — `config/mail_events.php`

Package: `ez-php/mail-events`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `mail_events.tolerance` | `MAIL_EVENTS_TOLERANCE` | int | `300` | Max. age (and clock skew) of a webhook timestamp in seconds — older requests are rejected (replay protection) |
| `mail_events.mailgun.signing_key` | `MAIL_EVENTS_MAILGUN_SIGNING_KEY` | string | `''` | Mailgun "HTTP webhook signing key"; empty registers no Mailgun route |
| `mail_events.mailgun.path` | `MAIL_EVENTS_MAILGUN_PATH` | string | `'/webhooks/mail/mailgun'` | Route path; empty registers no route |
| `mail_events.sendgrid.public_key` | `MAIL_EVENTS_SENDGRID_PUBLIC_KEY` | string | `''` | SendGrid Signed Event Webhook verification key (base64 as shown by SendGrid, or PEM); empty registers no SendGrid route |
| `mail_events.sendgrid.path` | `MAIL_EVENTS_SENDGRID_PATH` | string | `'/webhooks/mail/sendgrid'` | Route path; empty registers no route |
| `mail_events.postmark.username` | `MAIL_EVENTS_POSTMARK_USERNAME` | string | `''` | Basic-auth user you embed in the Postmark webhook URL (`https://user:pass@host/path`) |
| `mail_events.postmark.password` | `MAIL_EVENTS_POSTMARK_PASSWORD` | string | `''` | Basic-auth password for that URL; empty registers no Postmark route |
| `mail_events.postmark.path` | `MAIL_EVENTS_POSTMARK_PATH` | string | `'/webhooks/mail/postmark'` | Route path; empty registers no route |
| `mail_events.ses.topic_arn` | `MAIL_EVENTS_SES_TOPIC_ARN` | string | `''` | ARN of the SNS topic the SES configuration set publishes to; messages from any other topic are rejected. Empty registers no SES route |
| `mail_events.ses.path` | `MAIL_EVENTS_SES_PATH` | string | `'/webhooks/mail/ses'` | Route path (subscribe it to the SNS topic over HTTPS); empty registers no route |

---

### SMS — `config/sms.php`

Package: `ez-php/sms`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `sms.driver` | `SMS_DRIVER` | string | `'null'` | Driver: `twilio`, `vonage`, `log`, `array` (in-memory; tests), `null` |
| `sms.from` | `SMS_FROM` | string | `''` | Default sender number (E.164) or alphanumeric sender ID; required by `twilio`/`vonage` unless every message sets one |
| `sms.log_path` | `SMS_LOG_PATH` | string | `''` | Log file of the `log` driver; empty writes via `error_log()` |
| `sms.twilio.sid` | `SMS_TWILIO_SID` | string | `''` | Twilio Account SID |
| `sms.twilio.token` | `SMS_TWILIO_TOKEN` | string | `''` | Twilio Auth Token |
| `sms.vonage.key` | `SMS_VONAGE_KEY` | string | `''` | Vonage API key |
| `sms.vonage.secret` | `SMS_VONAGE_SECRET` | string | `''` | Vonage API secret |

---

### Metrics — `config/metrics.php`

Package: `ez-php/metrics`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `metrics.endpoint` | `METRICS_ENDPOINT` | string\|false | `'/metrics'` | Path of the Prometheus route; empty or `false` skips auto-registration |
| `metrics.storage` | `METRICS_STORAGE` | string | `'memory'` | `memory` (per process), `apcu` (one host, needs ext-apcu), `redis` (shared) |
| `metrics.prefix` | `METRICS_PREFIX` | string | `'ez-php:metrics:'` | Key prefix in APCu/Redis |
| `metrics.redis.host` / `.port` / `.database` | `METRICS_REDIS_HOST` / `_PORT` / `_DB` | string / int / int | `'127.0.0.1'` / `6379` / `0` | Redis connection for `storage = redis` |

The endpoint is unprotected. To put it behind middleware, set `METRICS_ENDPOINT=` (empty) and
register the route yourself, e.g. `$router->get('/metrics', [MetricsController::class, '__invoke'])->middleware(...)`.

---

### Metrics OTLP — `config/metrics_otlp.php`

Package: `ez-php/metrics-otlp`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `metrics_otlp.endpoint` | `METRICS_OTLP_ENDPOINT` | string | `''` | OTLP/HTTP metrics URL, e.g. `http://otel-collector:4318/v1/metrics`; empty disables the export |
| `metrics_otlp.service_name` | `METRICS_OTLP_SERVICE_NAME` | string | `''` | `service.name` resource attribute; empty uses `app.name`, else `ez-php-app` |
| `metrics_otlp.headers` | `METRICS_OTLP_HEADERS` | string | `''` | Extra request headers as `key=value,key2=value2` (URL-encoded values, as `OTEL_EXPORTER_OTLP_HEADERS`) |
| `metrics_otlp.max_points` | `METRICS_OTLP_MAX_POINTS` | int | `1000` | Export once this many values are waiting; the rest goes at process end |
| `metrics_otlp.timeout` | `METRICS_OTLP_TIMEOUT` | int | `5` | HTTP timeout in seconds |

Delta temporality: each export carries only what was recorded since the previous one. Collectors that
export to Prometheus need the `deltatocumulative` processor.

---

### OPcache preloading — `config/opcache.php`

Package: `ez-php/opcache`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `opcache.output_file` | `OPCACHE_PRELOAD_FILE` | string | `'<project>/preload.php'` (module default without the file: `''`) | Where `Preloader` writes the generated preload script |
| `opcache.paths` | — | list | framework + contracts `src/`, `app/` | Directories scanned for PHP files |
| `opcache.exclude` | — | list | `['*Test.php', '*TestCase.php', '*Interface.php']` | Filename glob patterns to skip |
| `opcache.require_once` | — | bool | `false` | Emit `require_once` instead of `opcache_compile_file()` |

---

### Swagger UI — `config/swagger-ui.php`

Package: `ez-php/swagger-ui`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `swagger-ui.endpoint` | `SWAGGER_UI_ENDPOINT` | string | `'/docs'` | Path of the documentation page |
| `swagger-ui.spec_url` | `SWAGGER_UI_SPEC_URL` | string | `'/openapi.json'` | URL the page loads the OpenAPI spec from |
| `swagger-ui.renderer` | `SWAGGER_UI_RENDERER` | string | `'swagger-ui'` | `swagger-ui` or `redoc` |

The page title comes from `app.name`.

---

## Environment Variable Quick Reference

A flat list of every variable — useful for generating `.env.example`.

```dotenv
# Application
APP_NAME=
APP_ENV=production
APP_DEBUG=false
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_VERSION=1.0.0
APP_URL_SIGNING_KEY=

# Docker host ports
APP_PORT=8001
DB_HOST_PORT=3308
REDIS_PORT=6383
MAIL_WEB_PORT=8025

# Database
DB_DRIVER=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_TESTING_DATABASE=

# Auth JWT (ez-php/auth, JwtServiceProvider)
JWT_SECRET=
JWT_TTL=3600

# Cache (ez-php/cache)
CACHE_DRIVER=array
CACHE_PATH=
CACHE_REDIS_HOST=127.0.0.1
CACHE_REDIS_PORT=6379
CACHE_REDIS_DB=0
CACHE_MEMCACHED_HOST=127.0.0.1
CACHE_MEMCACHED_PORT=11211
CACHE_MEMCACHED_WEIGHT=0
CACHE_DB_TABLE=cache
CACHE_DB_LOCK_TABLE=cache_locks
CACHE_PREFIX=

# OpenTelemetry (ez-php/otel)
OTEL_EXPORTER=
OTEL_EXPORTER_OTLP_ENDPOINT=
OTEL_SERVICE_NAME=ez-php-app
OTEL_SAMPLE_RATIO=1.0
OTEL_BATCH_SIZE=512

# Mail (ez-php/mail)
MAIL_DRIVER=null
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=none
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
MAIL_LOG_PATH=
MAIL_TIMEOUT=30
# Mailgun (MAIL_DRIVER=mailgun)
MAILGUN_DOMAIN=
MAILGUN_SECRET=
MAILGUN_REGION=us
# SendGrid (MAIL_DRIVER=sendgrid)
SENDGRID_API_KEY=
SENDGRID_REGION=us
# Postmark (MAIL_DRIVER=postmark)
POSTMARK_TOKEN=
# Amazon SES (MAIL_DRIVER=ses)
SES_ACCESS_KEY_ID=
SES_SECRET_ACCESS_KEY=
SES_REGION=us-east-1

# Mail Events (ez-php/mail-events)
MAIL_EVENTS_TOLERANCE=300
MAIL_EVENTS_MAILGUN_SIGNING_KEY=
MAIL_EVENTS_MAILGUN_PATH=/webhooks/mail/mailgun
MAIL_EVENTS_SENDGRID_PUBLIC_KEY=
MAIL_EVENTS_SENDGRID_PATH=/webhooks/mail/sendgrid
MAIL_EVENTS_POSTMARK_USERNAME=
MAIL_EVENTS_POSTMARK_PASSWORD=
MAIL_EVENTS_POSTMARK_PATH=/webhooks/mail/postmark
MAIL_EVENTS_SES_TOPIC_ARN=
MAIL_EVENTS_SES_PATH=/webhooks/mail/ses

# Queue (ez-php/queue)
QUEUE_DRIVER=database
QUEUE_REDIS_HOST=127.0.0.1
QUEUE_REDIS_PORT=6379
QUEUE_REDIS_DB=0

# Rate Limiter (ez-php/rate-limiter)
RATE_LIMITER_DRIVER=array
RATE_LIMITER_FILE_PATH=
RATE_LIMITER_REDIS_HOST=127.0.0.1
RATE_LIMITER_REDIS_PORT=6379
RATE_LIMITER_REDIS_DB=0
RATE_LIMITER_TRUSTED_PROXIES=

# Scheduler (ez-php/scheduler)
SCHEDULER_MUTEX=file
SCHEDULER_TTL=3600
SCHEDULER_LOCK_PATH=
SCHEDULER_REDIS_HOST=127.0.0.1
SCHEDULER_REDIS_PORT=6379
SCHEDULER_REDIS_DB=0

# Logging (ez-php/logging)
LOG_DRIVER=file
LOG_LEVEL=debug
LOG_PATH=
LOG_MAX_BYTES=0
LOG_SYSLOG_IDENT=ez-php
LOG_SYSLOG_FACILITY=user
LOG_JSON_INNER=stdout

# View (ez-php/view)
VIEW_PATH=resources/views

# Broadcast (ez-php/broadcast)
BROADCAST_DRIVER=null
BROADCAST_LOG_PATH=
BROADCAST_REDIS_HOST=127.0.0.1
BROADCAST_REDIS_PORT=6379
BROADCAST_REDIS_DB=0

# Search (ez-php/search)
SEARCH_DRIVER=null
MEILISEARCH_HOST=http://meilisearch:7700
MEILISEARCH_KEY=
# Host port of the opt-in meilisearch service in docker-compose.yml (not read by config/search.php)
MEILISEARCH_PORT=7702
ELASTICSEARCH_HOST=http://elasticsearch:9200
ELASTICSEARCH_USER=
ELASTICSEARCH_PASSWORD=
TYPESENSE_HOST=http://typesense:8108
TYPESENSE_KEY=
SEARCH_DB_TABLE=search_documents

# Storage (ez-php/storage)
STORAGE_DRIVER=local
STORAGE_ROOT=
STORAGE_URL=
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_ENDPOINT=
AWS_URL=
STORAGE_S3_URL_EXPIRY=3600
STORAGE_S3_MULTIPART_PART_SIZE=8388608
GCS_BUCKET=
GCS_ACCESS_TOKEN=
GCS_CLIENT_EMAIL=
GCS_PRIVATE_KEY=
GCS_URL_EXPIRY=3600
GCS_URL=
GCS_ENDPOINT=

# Health (ez-php/health) — own HEALTH_REDIS_HOST / HEALTH_REDIS_PORT (in-container port), not the host-published REDIS_PORT; unset host = no Redis probe
HEALTH_REDIS_HOST=redis
HEALTH_REDIS_PORT=6379
HEALTH_OPCACHE_ENABLED=false
HEALTH_DISK_PATHS=
HEALTH_DISK_DEGRADED_PERCENT=10
HEALTH_DISK_UNHEALTHY_PERCENT=5
HEALTH_LIVENESS_PATH=

# Feature Flags (ez-php/feature-flags)
FLAGS_DRIVER=file
FLAGS_FILE=flags.php
FLAGS_REDIS_HOST=127.0.0.1
FLAGS_REDIS_PORT=6379
FLAGS_REDIS_DB=0

# Sessions (ez-php/session)
SESSION_DRIVER=file
SESSION_FILE_PATH=
SESSION_TABLE=sessions
SESSION_REDIS_HOST=127.0.0.1
SESSION_REDIS_PORT=6379
SESSION_REDIS_DATABASE=0
SESSION_REDIS_TTL=1440
SESSION_CACHE_PREFIX=session:
SESSION_IDLE_LIFETIME=
SESSION_REGENERATE_INTERVAL=0
SESSION_STRICT_MODE=true
SESSION_COOKIE=
SESSION_SECURE_COOKIE=
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=Lax
SESSION_LIFETIME=0
SESSION_PATH=/
SESSION_DOMAIN=

# Webhooks (ez-php/webhook)
WEBHOOK_SECRET=
WEBHOOK_SIGNATURE_HEADER=X-Webhook-Signature
WEBHOOK_QUEUE=default
WEBHOOK_TIMESTAMPED=false
WEBHOOK_TOLERANCE=0

# AI Media (ez-php/ai-media) — shares OPENAI_API_KEY / GEMINI_API_KEY with ez-php/ai
AI_MEDIA_IMAGE_DRIVER=null
AI_MEDIA_TRANSCRIPTION_DRIVER=null
AI_MEDIA_SPEECH_DRIVER=null
AI_MEDIA_OPENAI_IMAGE_MODEL=dall-e-3
AI_MEDIA_OPENAI_TRANSCRIPTION_MODEL=whisper-1
AI_MEDIA_OPENAI_SPEECH_MODEL=tts-1
AI_MEDIA_GEMINI_BASE_URL=https://generativelanguage.googleapis.com
AI_MEDIA_GEMINI_IMAGE_MODEL=imagen-3.0-generate-002
AI_MEDIA_GEMINI_TRANSCRIPTION_MODEL=gemini-2.0-flash
AI_MEDIA_GEMINI_SPEECH_MODEL=gemini-2.5-flash-preview-tts

# OpenAPI (ez-php/openapi)
OPENAPI_ENDPOINT=/openapi.json
OPENAPI_VERSION=3.0

# AsyncAPI (ez-php/asyncapi)
ASYNCAPI_ENDPOINT=/asyncapi.json

# AsyncAPI UI (ez-php/asyncapi-ui)
ASYNCAPI_UI_ENDPOINT=/asyncapi-docs
ASYNCAPI_UI_DOCUMENT_URL=

# AI (ez-php/ai)
AI_DRIVER=null
AI_EMBEDDING_DRIVER=null
AI_STREAM_IDLE_TIMEOUT=120
AI_LOG_INNER_DRIVER=null
OPENAI_API_KEY=
OPENAI_MODEL=gpt-4o-mini
OPENAI_BASE_URL=https://api.openai.com
ANTHROPIC_API_KEY=
ANTHROPIC_MODEL=claude-sonnet-4-6
ANTHROPIC_API_VERSION=2023-06-01
GEMINI_API_KEY=
GEMINI_MODEL=gemini-2.0-flash
MISTRAL_API_KEY=
MISTRAL_MODEL=mistral-small-latest
MISTRAL_BASE_URL=https://api.mistral.ai
GROK_API_KEY=
GROK_MODEL=grok-3-mini
GROK_BASE_URL=https://api.x.ai

# GraphQL (ez-php/graphql)
GRAPHQL_ENDPOINT=/graphql
GRAPHQL_MAX_QUERY_DEPTH=15
GRAPHQL_MAX_QUERY_COMPLEXITY=200
GRAPHQL_PERSISTED_QUERIES=false
GRAPHQL_PERSISTED_QUERIES_TTL=0

# Media (ez-php/media)
MEDIA_DRIVER=gd

# Push (ez-php/push)
PUSH_DRIVER=null
PUSH_APNS_PRIVATE_KEY=
PUSH_APNS_KEY_ID=
PUSH_APNS_TEAM_ID=
PUSH_APNS_BUNDLE_ID=
PUSH_APNS_SANDBOX=false
PUSH_FCM_PRIVATE_KEY=
PUSH_FCM_PROJECT_ID=
PUSH_FCM_CLIENT_EMAIL=
PUSH_WEBPUSH_PRIVATE_KEY=
PUSH_WEBPUSH_SUBJECT=
PUSH_WEBPUSH_TTL=86400

# Encryption (ez-php/encryption)
ENCRYPTION_KEY=
ENCRYPTION_PREVIOUS_KEYS=

# Tenancy (ez-php/tenancy)
TENANCY_RESOLVER=subdomain
TENANCY_BASE_DOMAIN=
TENANCY_HEADER=X-Tenant
TENANCY_PATH_SEGMENT=0
TENANCY_REQUIRED=true
TENANCY_CACHE_PREFIX=tenant:

# SMS (ez-php/sms)
SMS_DRIVER=null
SMS_FROM=
SMS_LOG_PATH=
SMS_TWILIO_SID=
SMS_TWILIO_TOKEN=
SMS_VONAGE_KEY=
SMS_VONAGE_SECRET=

# Metrics (ez-php/metrics) — empty disables the auto-registered route
METRICS_ENDPOINT=/metrics
METRICS_STORAGE=memory
METRICS_PREFIX=ez-php:metrics:
METRICS_REDIS_HOST=127.0.0.1
METRICS_REDIS_PORT=6379
METRICS_REDIS_DB=0

# Metrics OTLP export (ez-php/metrics-otlp) — empty endpoint disables it
METRICS_OTLP_ENDPOINT=
METRICS_OTLP_SERVICE_NAME=
METRICS_OTLP_HEADERS=
METRICS_OTLP_MAX_POINTS=1000
METRICS_OTLP_TIMEOUT=5

# OPcache preloading (ez-php/opcache)
OPCACHE_PRELOAD_FILE=

# Swagger UI (ez-php/swagger-ui)
SWAGGER_UI_ENDPOINT=/docs
SWAGGER_UI_SPEC_URL=/openapi.json
SWAGGER_UI_RENDERER=swagger-ui
```
