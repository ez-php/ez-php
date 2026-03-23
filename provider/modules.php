<?php

declare(strict_types=1);

// Register optional module service providers here.
// Uncomment each line to activate the module.
// Install the corresponding Composer package first:
//   composer require ez-php/<module>

return [
    // ─── ORM ─────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/orm
    // EzPhp\Orm\EntityServiceProvider::class,
    // EzPhp\Orm\Schema\SchemaServiceProvider::class,

    // ─── Cache ───────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/cache
    // EzPhp\Cache\CacheServiceProvider::class,

    // ─── Events ──────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/events
    // EzPhp\Events\EventServiceProvider::class,

    // ─── Logging ─────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/logging
    // EzPhp\Logging\LogServiceProvider::class,

    // ─── Auth ────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/auth
    // EzPhp\Auth\AuthServiceProvider::class,

    // ─── Mail ────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/mail
    // EzPhp\Mail\MailServiceProvider::class,

    // ─── Queue ───────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/queue
    // EzPhp\Queue\QueueServiceProvider::class,

    // ─── Rate Limiter ─────────────────────────────────────────────────────────
    // Requires: composer require ez-php/rate-limiter
    // EzPhp\RateLimiter\RateLimiterServiceProvider::class,

    // ─── I18n ────────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/i18n
    // EzPhp\I18n\TranslatorServiceProvider::class,

    // ─── Validation ──────────────────────────────────────────────────────────
    // Requires: composer require ez-php/validation
    // EzPhp\Validation\ValidationServiceProvider::class,

    // ─── Search ──────────────────────────────────────────────────────────────
    // Requires: composer require ez-php/search
    // EzPhp\Search\SearchServiceProvider::class,

    // ─── Scheduler ───────────────────────────────────────────────────────────
    // Requires: composer require ez-php/scheduler
    // EzPhp\Scheduler\SchedulerServiceProvider::class,

    // ─── Broadcast ───────────────────────────────────────────────────────────
    // Requires: composer require ez-php/broadcast
    // EzPhp\Broadcast\BroadcastServiceProvider::class,

    // ─── Application providers ────────────────────────────────────────────────
    // App\Providers\AppServiceProvider::class,
];
