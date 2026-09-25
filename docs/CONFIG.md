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
| `app.lang_path` | — | string | `<project>/lang` | Directory holding `<locale>/*.php` translation files |
| `app.version` | `APP_VERSION` | string | `'1.0.0'` | Application version (used as the OpenAPI spec version) |

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
| `cache.driver` | `CACHE_DRIVER` | string | `'array'` | Driver: `array`, `file`, `redis`, `memcached` |
| `cache.file_path` | `CACHE_PATH` | string | `sys_get_temp_dir().'/ez-cache'` | Directory for the file cache driver |
| `cache.redis.host` | `CACHE_REDIS_HOST` | string | `'127.0.0.1'` | Redis host |
| `cache.redis.port` | `CACHE_REDIS_PORT` | int | `6379` | Redis port |
| `cache.redis.database` | `CACHE_REDIS_DB` | int | `0` | Redis database index |
| `cache.memcached.host` | `CACHE_MEMCACHED_HOST` | string | `'127.0.0.1'` | Memcached host |
| `cache.memcached.port` | `CACHE_MEMCACHED_PORT` | int | `11211` | Memcached port |
| `cache.memcached.weight` | `CACHE_MEMCACHED_WEIGHT` | int | `0` | Server weight |

Cache values must be `null`, scalars or arrays — every driver rejects objects.

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
| `broadcast.redis.host` | `BROADCAST_REDIS_HOST` | string | `'127.0.0.1'` | Redis host (redis driver only) |
| `broadcast.redis.port` | `BROADCAST_REDIS_PORT` | int | `6379` | Redis port |
| `broadcast.redis.database` | `BROADCAST_REDIS_DB` | int | `0` | Redis database index |

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
| `storage.s3.endpoint` | `AWS_ENDPOINT` | string\|null | `null` | Custom endpoint for MinIO, R2, Spaces, etc. |
| `storage.s3.url` | `AWS_URL` | string\|null | `null` | CDN base URL; overrides presigned URLs when set |
| `storage.s3.url_expiry` | `STORAGE_S3_URL_EXPIRY` | int | `3600` | Pre-signed URL lifetime in seconds |
| `storage.s3.multipart_part_size` | `STORAGE_S3_MULTIPART_PART_SIZE` | int | `8388608` | Part size for multipart `putStream()` uploads (≥ 5 MiB) |
| `storage.gcs.bucket` | `GCS_BUCKET` | string | `''` | Google Cloud Storage bucket |
| `storage.gcs.access_token` | `GCS_ACCESS_TOKEN` | string | `''` | OAuth2 Bearer token (refreshing it is the application's job) |
| `storage.gcs.url` | `GCS_URL` | string\|null | `null` | CDN/public base URL for `url()` |

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

Package: `ez-php/health` — only required when using the Redis probe.

```php
<?php
declare(strict_types=1);
return [
    'redis' => [
        'host' => getenv('HEALTH_REDIS_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('HEALTH_REDIS_PORT') ?: 6379),
    ],
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `health.redis.host` | `HEALTH_REDIS_HOST` | string | `'127.0.0.1'` | Redis host for the Redis probe; probe is skipped if this key is absent. Previously read `REDIS_HOST`/`REDIS_PORT` — rename them in existing `.env` files; `REDIS_PORT` in the template is the host-published port, not the in-container one |
| `health.redis.port` | `HEALTH_REDIS_PORT` | int | `6379` | Redis port for the Redis probe (in-container port) |
| `health.opcache.enabled` | `HEALTH_OPCACHE_ENABLED` | bool | `false` | Add the OPcache probe |

### Feature Flags — `config/flags.php`

Package: `ez-php/feature-flags` — ships with the template.

```php
<?php
declare(strict_types=1);
return [
    'driver' => getenv('FLAGS_DRIVER') ?: 'file',
    'file' => getenv('FLAGS_FILE') ?: 'flags.php',
    'rollouts' => [],
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `flags.driver` | `FLAGS_DRIVER` | string | `'file'` | Driver: `file`, `database`, `redis` |
| `flags.file` | `FLAGS_FILE` | string | `'flags.php'` | Path to the PHP flags definition file (file driver only) |
| `flags.redis.host` | `FLAGS_REDIS_HOST` | string | `'127.0.0.1'` | Redis host (redis driver only) |
| `flags.redis.port` | `FLAGS_REDIS_PORT` | int | `6379` | Redis port |
| `flags.redis.database` | `FLAGS_REDIS_DB` | int | `0` | Redis database index |
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

### OpenTelemetry — `config/otel.php`

Package: `ez-php/otel`

```php
<?php
declare(strict_types=1);
return [
    'exporter' => getenv('OTEL_EXPORTER') ?: null,
    'endpoint' => getenv('OTEL_EXPORTER_OTLP_ENDPOINT') ?: null,
    'service_name' => getenv('OTEL_SERVICE_NAME') ?: 'ez-php-app',
];
```

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `otel.exporter` | `OTEL_EXPORTER` | string\|null | `'otlp'` if an endpoint is set, else `'null'` | `otlp`, `memory`, or anything else to discard spans |
| `otel.endpoint` | `OTEL_EXPORTER_OTLP_ENDPOINT` | string\|null | `null` | Full OTLP/HTTP traces URL, e.g. `http://localhost:4318/v1/traces` |
| `otel.service_name` | `OTEL_SERVICE_NAME` | string | `'ez-php-app'` | `service.name` resource attribute |

### Sessions — `config/session.php`

Package: `ez-php/session`

| Config key | Env var | Type | Default | Description |
|---|---|---|---|---|
| `session.driver` | `SESSION_DRIVER` | string | `'file'` | Handler: `file`, `database`, `redis`, `array` |
| `session.file.path` | `SESSION_FILE_PATH` | string | `sys_get_temp_dir() . '/ez-session'` | Directory for the `file` driver |
| `session.database.table` | `SESSION_TABLE` | string | `'sessions'` | Table for the `database` driver; letters, digits and `_` only |
| `session.redis.host` | `SESSION_REDIS_HOST` | string | `'127.0.0.1'` | Redis host |
| `session.redis.port` | `SESSION_REDIS_PORT` | int | `6379` | Redis port |
| `session.redis.database` | `SESSION_REDIS_DATABASE` | int | `0` | Redis database index |
| `session.redis.ttl` | `SESSION_REDIS_TTL` | int | `1440` | Session lifetime in seconds |
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
| `push.driver` | `PUSH_DRIVER` | string | `'null'` | Driver: `apns`, `fcm`, `webpush`, `null` |
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

## Environment Variable Quick Reference

A flat list of every variable — useful for generating `.env.example`.

```dotenv
# Application
APP_NAME=
APP_DEBUG=false
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_VERSION=1.0.0

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
CACHE_MEMCACHED_HOST=127.0.0.1
CACHE_MEMCACHED_PORT=11211
CACHE_MEMCACHED_WEIGHT=0

# OpenTelemetry (ez-php/otel)
OTEL_EXPORTER=
OTEL_EXPORTER_OTLP_ENDPOINT=
OTEL_SERVICE_NAME=ez-php-app

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
RATE_LIMITER_FILE_PATH=
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
BROADCAST_REDIS_HOST=127.0.0.1
BROADCAST_REDIS_PORT=6379
BROADCAST_REDIS_DB=0

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
STORAGE_S3_URL_EXPIRY=3600
STORAGE_S3_MULTIPART_PART_SIZE=8388608
GCS_BUCKET=
GCS_ACCESS_TOKEN=
GCS_URL=

# Health (ez-php/health) — shares REDIS_HOST / REDIS_PORT with other modules
HEALTH_REDIS_HOST=127.0.0.1
HEALTH_REDIS_PORT=6379
HEALTH_OPCACHE_ENABLED=false

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
```
