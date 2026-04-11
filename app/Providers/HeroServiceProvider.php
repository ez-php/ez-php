<?php

declare(strict_types=1);

namespace App\Providers;

use EzPhp\ServiceProvider\ServiceProvider;

/**
 * Class HeroServiceProvider
 *
 * Registers hero-domain bindings: repositories, services, and factories
 * that relate to the Hero aggregate.
 *
 * @package App\Providers
 */
class HeroServiceProvider extends ServiceProvider
{
    /**
     * Register hero-domain services.
     *
     * @return void
     */
    public function register(): void
    {
        // Bind HeroRepository, HeroFactory, etc. to the container here.
    }

    /**
     * Bootstrap hero-domain services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Register event listeners or other boot-time wiring for the hero domain.
    }
}
