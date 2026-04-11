<?php

declare(strict_types=1);

namespace App\Providers;

use EzPhp\ServiceProvider\ServiceProvider;

/**
 * Class AuthServiceProvider
 *
 * Registers authentication-related bindings and services.
 * Place session guard configuration, auth driver bindings, and gate/policy
 * registrations here.
 *
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register authentication services.
     *
     * @return void
     */
    public function register(): void
    {
        // Bind auth-related services to the container here.
        // Example:
        //   $this->app->bind(UserRepository::class, fn () => new UserRepository($this->app->make(DatabaseInterface::class)));
    }

    /**
     * Bootstrap authentication services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Register gates, policies, or session driver configuration here.
    }
}
