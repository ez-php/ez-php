<?php

declare(strict_types=1);

// Register optional module service providers here.
// Uncomment each line to activate the module.
// Install the corresponding Composer package first:
//   composer require ez-php/<module>

return [
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

    // ─── Application providers ────────────────────────────────────────────────
    // App\Providers\AppServiceProvider::class,
];
