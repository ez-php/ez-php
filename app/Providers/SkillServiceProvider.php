<?php

declare(strict_types=1);

namespace App\Providers;

use EzPhp\ServiceProvider\ServiceProvider;

/**
 * Class SkillServiceProvider
 *
 * Registers skill-domain bindings: repositories, services, and factories
 * that relate to the Skill aggregate.
 *
 * @package App\Providers
 */
class SkillServiceProvider extends ServiceProvider
{
    /**
     * Register skill-domain services.
     *
     * @return void
     */
    public function register(): void
    {
        // Bind SkillRepository, SkillService, etc. to the container here.
    }

    /**
     * Bootstrap skill-domain services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Register event listeners or other boot-time wiring for the skill domain.
    }
}
