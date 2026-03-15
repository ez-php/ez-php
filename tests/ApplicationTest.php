<?php

declare(strict_types=1);

namespace Tests;

use App\Providers\AppServiceProvider;
use EzPhp\Application\Application;
use EzPhp\Exceptions\ApplicationException;
use EzPhp\Exceptions\ContainerException;
use PHPUnit\Framework\Attributes\CoversClass;
use ReflectionException;

/**
 * Class ApplicationTest
 *
 * Smoke test: verifies the application template bootstraps without errors.
 *
 * @package Tests
 */
#[CoversClass(AppServiceProvider::class)]
final class ApplicationTest extends TestCase
{
    /**
     * @throws ApplicationException
     * @throws ContainerException
     * @throws ReflectionException
     */
    public function test_application_bootstraps_with_app_service_provider(): void
    {
        $app = new Application();
        $app->register(AppServiceProvider::class);
        $app->bootstrap();

        $this->assertInstanceOf(Application::class, $app->make(Application::class));
    }
}
