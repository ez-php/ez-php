# Testing Guide

A reference for writing tests in ez-php applications.

---

## Test base classes

ez-php ships two test packages:

| Package | What it provides | Depends on framework? |
|---|---|---|
| `ez-php/testing` | `TestResponse`, `EntityFactory` | No |
| `ez-php/testing-application` | `ApplicationTestCase`, `DatabaseTestCase`, `HttpTestCase` | Yes |

Both are `require-dev` dependencies — the application template includes `ez-php/testing-application` out of the box.

---

## TestCase

`tests/TestCase.php` is the minimal base for pure unit tests. It extends PHPUnit's `TestCase` directly and does not boot the application.

```php
namespace Tests;

use Tests\TestCase;

final class CalculatorTest extends TestCase
{
    public function test_adds_two_numbers(): void
    {
        $this->assertSame(4, 2 + 2);
    }
}
```

Use this for plain PHP logic that has no framework dependency.

---

## ApplicationTestCase

`tests/ApplicationTestCase.php` extends `EzPhp\Testing\ApplicationTestCase` (from `ez-php/testing-application`). It bootstraps a fresh `Application` instance before every test.

**Key methods:**

| Method | Purpose |
|---|---|
| `configureApplication(Application $app)` | Override to register providers, middleware, or routes before bootstrap |
| `app(): Application` | Returns the bootstrapped Application |
| `getBasePath(): string` | Override to point to a custom application root; default creates a temp dir |

**Example — testing a service provider:**

```php
namespace Tests;

use App\Providers\AppServiceProvider;
use EzPhp\Application\Application;

final class MyServiceProviderTest extends ApplicationTestCase
{
    protected function configureApplication(Application $app): void
    {
        $app->register(AppServiceProvider::class);
    }

    public function test_service_is_bound(): void
    {
        $this->assertInstanceOf(
            MyService::class,
            $this->app()->make(MyService::class),
        );
    }
}
```

> `configureApplication()` is called **before** `bootstrap()`. Do not call `$app->make()` inside it.

---

## HttpTestCase

`HttpTestCase` extends `ApplicationTestCase` and adds HTTP helpers. Requests travel through the full middleware pipeline, router, and exception handler — no HTTP server required.

**Available helpers:**

```php
$this->get('/path', $headers);
$this->post('/path', $body, $headers);
$this->put('/path', $body, $headers);
$this->delete('/path', $headers);
$this->request('PATCH', '/path', $body, $headers);
```

All methods return a `TestResponse`.

**Example:**

```php
namespace Tests;

use App\Providers\AppServiceProvider;
use EzPhp\Application\Application;
use EzPhp\Routing\Router;

final class UserControllerTest extends ApplicationTestCase
{
    protected function configureApplication(Application $app): void
    {
        $app->register(AppServiceProvider::class);
    }

    public function test_index_returns_200(): void
    {
        $this->get('/users')->assertOk();
    }

    public function test_store_creates_user(): void
    {
        $this->post('/users', ['name' => 'Alice', 'email' => 'alice@example.com'])
            ->assertStatus(201)
            ->assertJson(['name' => 'Alice']);
    }
}
```

You can also register routes inline via a service provider defined in the test file:

```php
use EzPhp\Contracts\ServiceProvider;
use EzPhp\Http\Response;
use EzPhp\Routing\Router;

class TestRouteProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $router = $this->app->make(Router::class);
        $router->get('/ping', fn () => new Response('pong'));
    }
}
```

---

## DatabaseTestCase

`DatabaseTestCase` extends `ApplicationTestCase`. It wraps every test method in a database transaction and rolls it back unconditionally in `tearDown()`. No table truncation required.

**Key methods:**

| Method | Purpose |
|---|---|
| `pdo(): PDO` | Returns the raw PDO connection for direct queries |

**Requirements:**

- The application must be configured with a working database connection.
- Override `getBasePath()` to point to an application root with a valid `config/db.php`.
- For fast in-process tests (no MySQL), configure SQLite: `['driver' => 'sqlite', 'database' => ':memory:']`.

**Example with MySQL (integration tests):**

```php
namespace Tests;

use App\Providers\AppServiceProvider;
use EzPhp\Application\Application;
use EzPhp\Testing\DatabaseTestCase;

final class UserRepositoryTest extends DatabaseTestCase
{
    protected function getBasePath(): string
    {
        return dirname(__DIR__); // points to the real application root
    }

    protected function configureApplication(Application $app): void
    {
        $app->register(AppServiceProvider::class);
    }

    public function test_saves_user(): void
    {
        $this->pdo()->exec("INSERT INTO users (name, email) VALUES ('Bob', 'bob@example.com')");

        $row = $this->pdo()->query("SELECT * FROM users WHERE email = 'bob@example.com'")->fetch();

        $this->assertSame('Bob', $row['name']);
        // transaction is rolled back after this test — no cleanup needed
    }
}
```

> Database tests require Docker to be running (`docker compose up -d`). They run against the `DB_TESTING_DATABASE` database defined in `.env`.

---

## TestResponse assertions

All HTTP helpers return a `TestResponse`. Assertions are fluent and chainable.

| Method | Asserts |
|---|---|
| `assertStatus(int $status)` | Status code equals the given value |
| `assertOk()` | Status is 200 |
| `assertNotFound()` | Status is 404 |
| `assertRedirect(?string $location)` | Status is 3xx; optionally checks `Location` header |
| `assertSee(string $text)` | Body contains the string |
| `assertJson(array $expected)` | Body decodes to JSON and equals the array (strict) |
| `assertHeader(string $name, ?string $value)` | Header exists; optionally checks exact value |

**Reading raw values:**

```php
$response = $this->get('/api/users');

$response->status();    // int
$response->body();      // string
$response->headers();   // array<string, string>
```

**Chaining:**

```php
$this->post('/api/users', ['name' => 'Alice'])
    ->assertStatus(201)
    ->assertJson(['name' => 'Alice'])
    ->assertHeader('Content-Type', 'application/json');
```

---

## EntityFactory

`EntityFactory` (from `ez-php/testing`, requires `ez-php/orm`) builds and optionally persists `Entity` instances. Default attribute values can be static or callable — callables are invoked once per instance.

```php
use EzPhp\Testing\EntityFactory;
use App\Entities\User;
use App\Repositories\UserRepository;

$factory = new EntityFactory(User::class, $userRepository, [
    'name'  => 'Alice',
    'email' => fn () => uniqid('user_') . '@example.com',
    'role'  => 'user',
]);

$user  = $factory->make();                        // attributes set, not persisted
$user  = $factory->create();                      // persisted via repository->save()
$users = $factory->makeMany(3);                   // list<User>, not persisted
$users = $factory->createMany(5, ['role' => 'admin']); // list<User>, all persisted
```

Overrides merge on top of defaults:

```php
$admin = $factory->create(['role' => 'admin']);
```

> `make()` and `makeMany()` do not need a database connection. `create()` and `createMany()` require a working repository.

---

## Running tests

All commands run inside the Docker container:

```bash
docker compose exec app composer test      # PHPUnit with coverage
docker compose exec app composer analyse   # PHPStan level 9
docker compose exec app composer cs        # php-cs-fixer (auto-fix)
docker compose exec app composer full      # all three in sequence
```

Run a single test file:

```bash
docker compose exec app vendor/bin/phpunit tests/UserControllerTest.php
```

Run a single test method:

```bash
docker compose exec app vendor/bin/phpunit --filter test_index_returns_200
```

---

## Infrastructure requirements

| Test type | MySQL | Redis | Docker |
|---|---|---|---|
| Unit (`TestCase`) | No | No | No |
| Application (`ApplicationTestCase`) | No | No | No |
| HTTP (`HttpTestCase`) | No | No | No |
| Database (`DatabaseTestCase`) with MySQL | Yes | No | Yes |
| Database (`DatabaseTestCase`) with SQLite | No | No | No |

For tests that need MySQL, Docker must be running and the database must exist. The `docker/db/create-db.sh` script creates both `DB_DATABASE` and `DB_TESTING_DATABASE` on first start.

---

## Conventions

- Test classes live in `tests/`, namespace `Tests\`, mirroring `app/`.
- Test file names end in `Test.php`, methods start with `test_`.
- Use `#[CoversClass(MyClass::class)]` on every test class for accurate coverage reports.
- Prefer `DatabaseTestCase` over manual `setUp`/`tearDown` truncation.
- Prefer `HttpTestCase` over unit-testing controllers in isolation — the full stack gives more confidence.
