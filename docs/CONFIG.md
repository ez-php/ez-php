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

### Database — `config/db.php`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `db.driver` | `DB_DRIVER` | string | `'mysql'` | PDO driver (`mysql`, `sqlite`, etc.) |
| `db.host` | `DB_HOST` | string | — | Database host |
| `db.port` | `DB_PORT` | string | — | Database port |
| `db.database` | `DB_DATABASE` | string | — | Database name |
| `db.username` | `DB_USERNAME` | string | — | Database username |
| `db.password` | `DB_PASSWORD` | string | — | Database password |
| `db.testing_database` | `DB_TESTING_DATABASE` | string | — | Separate database for test runs (used by `DatabaseTestCase`) |

---

## Optional Modules

### Cache — `config/cache.php`

Package: `ez-php/cache`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `cache.driver` | `CACHE_DRIVER` | string | `'array'` | Driver: `array`, `file`, `redis` |
| `cache.file_path` | `CACHE_PATH` | string | `sys_get_temp_dir().'/ez-cache'` | Directory for the file cache driver |
| `cache.redis.host` | `CACHE_REDIS_HOST` | string | `'127.0.0.1'` | Redis host |
| `cache.redis.port` | `CACHE_REDIS_PORT` | int | `6379` | Redis port |
| `cache.redis.database` | `CACHE_REDIS_DB` | int | `0` | Redis database index |

### Mail — `config/mail.php`

Package: `ez-php/mail`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `mail.driver` | `MAIL_DRIVER` | string | `'null'` | Driver: `smtp`, `mailgun`, `sendgrid`, `log`, `null` |
| `mail.from_address` | `MAIL_FROM_ADDRESS` | string | `''` | Default sender address (all drivers) |
| `mail.from_name` | `MAIL_FROM_NAME` | string | `''` | Default sender display name (all drivers) |
| `mail.log_path` | `MAIL_LOG_PATH` | string | `''` | Log file path (log driver only) |

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

### Queue — `config/queue.php`

Package: `ez-php/queue`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `queue.driver` | `QUEUE_DRIVER` | string | `'database'` | Driver: `database`, `redis` |
| `queue.redis.host` | `QUEUE_REDIS_HOST` | string | `'127.0.0.1'` | Redis host |
| `queue.redis.port` | `QUEUE_REDIS_PORT` | int | `6379` | Redis port |
| `queue.redis.database` | `QUEUE_REDIS_DB` | int | `0` | Redis database index |

### Rate Limiter — `config/rate_limiter.php`

Package: `ez-php/rate-limiter`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `rate_limiter.driver` | `RATE_LIMITER_DRIVER` | string | `'array'` | Driver: `array`, `redis`, `cache_delegate` |
| `rate_limiter.redis.host` | `RATE_LIMITER_REDIS_HOST` | string | `'127.0.0.1'` | Redis host |
| `rate_limiter.redis.port` | `RATE_LIMITER_REDIS_PORT` | int | `6379` | Redis port |
| `rate_limiter.redis.database` | `RATE_LIMITER_REDIS_DB` | int | `0` | Redis database index |

### Logging — `config/logging.php`

Package: `ez-php/logging`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `logging.driver` | `LOG_DRIVER` | string | `'file'` | Driver: `file`, `stdout`, `null`, `json`, `stack` |
| `logging.path` | `LOG_PATH` | string | `''` | Log directory for the `file` driver (defaults to `storage/logs` when empty) |
| `logging.max_bytes` | `LOG_MAX_BYTES` | int | `0` | Max file size in bytes before rotation; `0` = no size limit |
| `logging.min_level` | `LOG_LEVEL` | string | `''` | Minimum level to write: `debug`, `info`, `warning`, `error`, `critical`; empty = all |
| `logging.json_inner` | `LOG_JSON_INNER` | string | `'stdout'` | Inner driver for the `json` driver: `file`, `stdout`, `null` |
| `logging.stack` | — | array | `['file','stdout']` | Drivers for the `stack` driver; configured in `config/logging.php` directly |

**Driver overview:**

| Driver | Description |
|---|---|
| `file` | Appends JSON-or-text lines to `LOG_PATH/app-YYYY-MM-DD.log`; date-rotated automatically |
| `stdout` | `debug`/`info`/`warning` → stdout; `error`/`critical` → stderr |
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

### Search — `config/search.php`

Package: `ez-php/search`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `search.driver` | `SEARCH_DRIVER` | string | `'null'` | Driver: `null`, `meilisearch`, `elasticsearch`, `typesense` |

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
        'url_expiry' => 3600,
    ],
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `storage.driver` | `STORAGE_DRIVER` | string | `'local'` | Driver: `local`, `s3` |
| `storage.local.root` | `STORAGE_ROOT` | string | `''` | Absolute path to the storage root directory |
| `storage.local.url` | `STORAGE_URL` | string | `''` | Public base URL for local files (e.g. CDN prefix) |
| `storage.s3.key` | `AWS_ACCESS_KEY_ID` | string | — | AWS / S3-compatible access key ID |
| `storage.s3.secret` | `AWS_SECRET_ACCESS_KEY` | string | — | AWS / S3-compatible secret access key |
| `storage.s3.region` | `AWS_DEFAULT_REGION` | string | `'us-east-1'` | AWS region |
| `storage.s3.bucket` | `AWS_BUCKET` | string | — | S3 bucket name |
| `storage.s3.endpoint` | `AWS_ENDPOINT` | string\|null | `null` | Custom endpoint for MinIO, R2, Spaces, etc. |
| `storage.s3.url` | `AWS_URL` | string\|null | `null` | CDN base URL; overrides presigned URLs when set |

### Health — `config/health.php`

Package: `ez-php/health` — only required when using the Redis probe.

```php
<?php
declare(strict_types=1);
return [
    'redis' => [
        'host' => getenv('REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('REDIS_PORT') ?: 6379),
    ],
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `health.redis.host` | `REDIS_HOST` | string | `'127.0.0.1'` | Redis host for the Redis probe; probe is skipped if this key is absent |
| `health.redis.port` | `REDIS_PORT` | int | `6379` | Redis port for the Redis probe |

### Feature Flags — `config/flags.php`

Package: `ez-php/feature-flags` — create this file in your application's `config/` directory.

```php
<?php
declare(strict_types=1);
return [
    'flags' => [
        'driver' => getenv('FLAGS_DRIVER') ?: 'file',
        'file'   => __DIR__ . '/flags.php',
    ],
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `flags.driver` | `FLAGS_DRIVER` | string | `'file'` | Driver: `file`, `database`, `array` |
| `flags.file` | — | string | `'config/flags.php'` | Path to the PHP flags file (file driver only) |

**Flag definitions** (file driver) — create `config/flags.php`:

```php
<?php
return [
    'new-checkout' => true,
    'dark-mode'    => false,
];
```

---

## Environment Variable Quick Reference

A flat list of every variable — useful for generating `.env.example`.

```dotenv
# Application
APP_NAME=
APP_DEBUG=false
APP_LOCALE=en
APP_FALLBACK_LOCALE=en

# Database
DB_DRIVER=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_TESTING_DATABASE=

# Cache (ez-php/cache)
CACHE_DRIVER=array
CACHE_PATH=
CACHE_REDIS_HOST=127.0.0.1
CACHE_REDIS_PORT=6379
CACHE_REDIS_DB=0

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
# Mailgun (MAIL_DRIVER=mailgun)
MAILGUN_DOMAIN=
MAILGUN_SECRET=
MAILGUN_REGION=us
# SendGrid (MAIL_DRIVER=sendgrid)
SENDGRID_API_KEY=

# Queue (ez-php/queue)
QUEUE_DRIVER=database
QUEUE_REDIS_HOST=127.0.0.1
QUEUE_REDIS_PORT=6379
QUEUE_REDIS_DB=0

# Rate Limiter (ez-php/rate-limiter)
RATE_LIMITER_DRIVER=array
RATE_LIMITER_REDIS_HOST=127.0.0.1
RATE_LIMITER_REDIS_PORT=6379
RATE_LIMITER_REDIS_DB=0

# Logging (ez-php/logging)
LOG_DRIVER=file
LOG_LEVEL=debug
LOG_PATH=
LOG_MAX_BYTES=0
LOG_JSON_INNER=stdout

# View (ez-php/view)
VIEW_PATH=resources/views

# Broadcast (ez-php/broadcast)
BROADCAST_DRIVER=null
BROADCAST_LOG_PATH=

# Search (ez-php/search)
SEARCH_DRIVER=null
MEILISEARCH_HOST=http://meilisearch:7700
MEILISEARCH_KEY=
ELASTICSEARCH_HOST=http://elasticsearch:9200
ELASTICSEARCH_USER=
ELASTICSEARCH_PASSWORD=
TYPESENSE_HOST=http://typesense:8108
TYPESENSE_KEY=

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

# Health (ez-php/health) — shares REDIS_HOST / REDIS_PORT with other modules
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

# Feature Flags (ez-php/feature-flags)
FLAGS_DRIVER=file
```
