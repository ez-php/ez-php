<?php

declare(strict_types=1);

namespace App\Providers;

use EzPhp\ServiceProvider\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * Application-level service provider. Register bindings and boot application
 * services here.
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }
}
