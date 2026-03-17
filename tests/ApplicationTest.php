<?php

declare(strict_types=1);

namespace Tests;

use App\Providers\AppServiceProvider;
use EzPhp\Application\Application;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Class ApplicationTest
 *
 * Smoke test: verifies the application template bootstraps without errors.
 *
 * @package Tests
 */
#[CoversClass(AppServiceProvider::class)]
final class ApplicationTest extends ApplicationTestCase
{
    /**
     * @param Application $app
     *
     * @return void
     */
    protected function configureApplication(Application $app): void
    {
        $app->register(AppServiceProvider::class);
    }

    /**
     * @return void
     */
    public function test_application_bootstraps_with_app_service_provider(): void
    {
        $this->assertInstanceOf(Application::class, $this->app()->make(Application::class));
    }
}
