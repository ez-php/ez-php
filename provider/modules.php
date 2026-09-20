<?php

declare(strict_types=1);

// Register optional module service providers here.
// Uncomment each line to activate the module.
// Install the corresponding Composer package first:
//   composer require ez-php/<module>

use App\Providers\AppServiceProvider;

return [
    // ─── AI ──────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/ai
    // EzPhp\Ai\AiServiceProvider::class,

    // ─── Auth ────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/auth
    // EzPhp\Auth\AuthServiceProvider::class,

    // ─── Broadcast ───────────────────────────────────────────────────────────
    // Requires: composer require ez-php/broadcast
    // EzPhp\Broadcast\BroadcastServiceProvider::class,

    // ─── Cache ───────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/cache
    // EzPhp\Cache\CacheServiceProvider::class,

    // ─── Events ──────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/events
    // EzPhp\Events\EventServiceProvider::class,

    // ─── HTTP Client ─────────────────────────────────────────────────────────
    // Requires: composer require ez-php/http-client
    // EzPhp\HttpClient\HttpClientServiceProvider::class,

    // ─── I18n ────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/i18n
    // EzPhp\I18n\TranslatorServiceProvider::class,

    // ─── Logging ─────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/logging
    // EzPhp\Logging\LogServiceProvider::class,

    // ─── Mail ────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/mail
    // EzPhp\Mail\MailServiceProvider::class,

    // ─── ORM ─────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/orm
    // EzPhp\Orm\EntityServiceProvider::class,
    // EzPhp\Orm\Schema\SchemaServiceProvider::class,

    // ─── OpenTelemetry ───────────────────────────────────────────────────────
    // Requires: composer require ez-php/otel
    // EzPhp\Otel\OtelServiceProvider::class,

    // ─── Queue ───────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/queue
    // EzPhp\Queue\QueueServiceProvider::class,

    // ─── Rate Limiter ─────────────────────────────────────────────────────────
    // Requires: composer require ez-php/rate-limiter
    // EzPhp\RateLimiter\RateLimiterServiceProvider::class,

    // ─── Scheduler ───────────────────────────────────────────────────────────
    // Requires: composer require ez-php/scheduler
    // Note: register manually — Scheduler has no ServiceProvider.
    // See modules/scheduler/README.md for setup instructions.

    // ─── Search ──────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/search
    // EzPhp\Search\SearchServiceProvider::class,

    // ─── Validation ──────────────────────────────────────────────────────────
    // Requires: composer require ez-php/validation
    // EzPhp\Validation\ValidationServiceProvider::class,

    // ─── View ────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/view
    // EzPhp\View\ViewServiceProvider::class,

    // ─── Notification ────────────────────────────────────────────────────────
    // Requires: composer require ez-php/notification
    // EzPhp\Notification\NotificationServiceProvider::class,

    // ─── Storage ─────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/storage
    // EzPhp\Storage\StorageServiceProvider::class,

    // ─── Health ──────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/health
    // EzPhp\Health\HealthServiceProvider::class,

    // ─── Feature Flags ───────────────────────────────────────────────────────
    // Requires: composer require ez-php/feature-flags
    // EzPhp\FeatureFlags\FeatureFlagServiceProvider::class,

    // ─── Audit ───────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/audit
    // Register after the database and EventServiceProvider — audit degrades to "disabled" without them.
    // EzPhp\Audit\AuditServiceProvider::class,

    // ─── Auth: JWT ───────────────────────────────────────────────────────────
    // Requires: composer require ez-php/auth   (same package as AuthServiceProvider)
    // Needs JWT_SECRET; register CacheServiceProvider first if you use JwtBlacklist.
    // EzPhp\Auth\JwtServiceProvider::class,

    // ─── Event Store ─────────────────────────────────────────────────────────
    // Requires: composer require ez-php/event-store
    // Needs a bound DatabaseInterface.
    // EzPhp\EventStore\EventStoreServiceProvider::class,

    // ─── GraphQL ─────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/graphql
    // Bind a GraphQL\Type\Schema in your own provider and list that provider BEFORE this one.
    // EzPhp\GraphQL\GraphQLServiceProvider::class,

    // ─── Media ───────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/media   (ext-gd or ext-imagick)
    // EzPhp\Media\MediaServiceProvider::class,

    // ─── Metrics ─────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/metrics
    // Registers GET /metrics.
    // EzPhp\Metrics\MetricsServiceProvider::class,

    // ─── OPcache preloading ──────────────────────────────────────────────────
    // Requires: composer require ez-php/opcache
    // EzPhp\OPCache\PreloaderServiceProvider::class,

    // ─── OpenAPI ─────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/openapi
    // Registers GET /openapi.json.
    // EzPhp\OpenApi\OpenApiServiceProvider::class,

    // ─── Push notifications ──────────────────────────────────────────────────
    // Requires: composer require ez-php/push
    // Register HttpClientServiceProvider before it (the apns/fcm drivers resolve HttpClient).
    // EzPhp\Push\PushServiceProvider::class,

    // ─── Swagger UI ──────────────────────────────────────────────────────────
    // Requires: composer require ez-php/swagger-ui
    // Serves documentation for the spec produced by ez-php/openapi.
    // EzPhp\SwaggerUI\SwaggerUiServiceProvider::class,

    // ─── Authorization (gates & policies) ────────────────────────────────────
    // Requires: composer require ez-php/authorization   (builds on ez-php/auth)
    // EzPhp\Authorization\AuthorizationServiceProvider::class,

    // ─── Two-factor authentication ───────────────────────────────────────────
    // Requires: composer require ez-php/two-factor   (builds on ez-php/auth)
    // EzPhp\TwoFactor\TwoFactorServiceProvider::class,

    // ─── Application providers ────────────────────────────────────────────────
    AppServiceProvider::class,
];
