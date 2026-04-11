<?php

declare(strict_types=1);

namespace App\Providers;

use EzPhp\ServiceProvider\ServiceProvider;

/**
 * Class BattleServiceProvider
 *
 * Registers battle-domain bindings: repositories, services, and factories
 * that relate to the Battle aggregate.
 *
 * @package App\Providers
 */
class BattleServiceProvider extends ServiceProvider
{
    /**
     * Register battle-domain services.
     *
     * @return void
     */
    public function register(): void
    {
        // Bind BattleRepository, BattleService, etc. to the container here.
    }

    /**
     * Bootstrap battle-domain services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Register event listeners or other boot-time wiring for the battle domain.
    }
}
