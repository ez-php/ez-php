# Upgrade Guide: Active Record → Data Mapper

ez-php's ORM has moved from the Active Record pattern (`Model`) to the Data Mapper pattern
(`Entity` + `AbstractRepository`). `EzPhp\Orm\Model`, its query builder and `ModelTestCase` have been
**removed** — applications still extending `Model` must migrate before upgrading `ez-php/orm`.
The framework's `make:model` command was removed with it; use `make:entity` / `make:repository`
(registered by `EntityServiceProvider`).

This guide walks through converting a typical Active Record model to the Data Mapper pattern.

---

## Why migrate?

| Active Record (`Model`) | Data Mapper (`Entity` + `AbstractRepository`) |
|---|---|
| Entity and persistence are one class | Entity is pure data; repository handles persistence |
| `User::find($id)` couples domain to DB | `$userRepo->find($id)` — dependency-injected |
| Testing requires a DB connection to instantiate a model | Entities can be instantiated and tested without a DB |
| 50+ methods on every model | Small, focused classes |
| Static DB registry | Constructor injection (DI container-friendly) |

---

## Step-by-step migration

### 1 — Create the entity

Run the scaffold command:

```bash
php ez make:entity User
```

This creates `app/Entities/User.php`:

```php
<?php

declare(strict_types=1);

namespace App\Entities;

use EzPhp\Orm\Entity;

class User extends Entity
{
    protected static string $table = 'users';

    /** @var list<string> */
    protected static array $fillable = ['name', 'email', 'password'];
}
```

**Before (Active Record):**

```php
class User extends Model
{
    protected static string $table = 'users';
    protected static array $fillable = ['name', 'email', 'password'];
}
```

The entity class carries the same schema configuration (`$table`, `$fillable`, `$casts`,
`$timestamps`, `$softDeletes`) — only the base class changes.

---

### 2 — Create the repository

```bash
php ez make:repository User
```

The argument is the **entity** name; the command appends `Repository`.

This creates `app/Repositories/UserRepository.php`:

```php
<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use EzPhp\Orm\AbstractRepository;

/**
 * @extends AbstractRepository<User>
 */
class UserRepository extends AbstractRepository
{
    protected function entityClass(): string
    {
        return User::class;
    }
}
```

Add custom query methods as needed:

```php
public function findByEmail(string $email): ?User
{
    return $this->query()->where('email', $email)->first();
}

/** @return list<User> */
public function findActive(): array
{
    return $this->query()->where('active', 1)->get();
}
```

---

### 3 — Register in the service provider (optional, for DI)

If you want the container to autowire the repository, bind it in `AppServiceProvider`:

```php
public function register(): void
{
    $this->app->bind(UserRepository::class, UserRepository::class);
}
```

With `EntityServiceProvider` active, the container can already resolve `DatabaseInterface` and
`Hydrator` automatically — concrete repositories are autowired without explicit bindings.

---

### 4 — Update your controllers

**Before:**

```php
class UserController
{
    public function show(Request $request, string $id): Response
    {
        $user = User::find((int) $id);
        // ...
    }

    public function store(Request $request): Response
    {
        $user = new User($request->only(['name', 'email']));
        $user->save();
        // ...
    }

    public function destroy(Request $request, string $id): Response
    {
        $user = User::find((int) $id);
        $user?->delete();
        // ...
    }
}
```

**After:**

```php
class UserController
{
    public function __construct(
        private readonly UserRepository $users,
    ) {}

    public function show(Request $request, string $id): Response
    {
        $user = $this->users->find((int) $id);
        // ...
    }

    public function store(Request $request): Response
    {
        $user = new User($request->only(['name', 'email']));
        $this->users->save($user);
        // ...
    }

    public function destroy(Request $request, string $id): Response
    {
        $user = $this->users->find((int) $id);
        if ($user !== null) {
            $this->users->delete($user);
        }
        // ...
    }
}
```

---

## API reference

### Queries

| Active Record | Data Mapper |
|---|---|
| `User::find($id)` | `$userRepo->find($id)` |
| `User::findAll()` | `$userRepo->findAll()` |
| `User::findBy('email', $e)` | `$userRepo->findBy('email', $e)` |
| `User::where('active', 1)->get()` | `$userRepo->query()->where('active', 1)->get()` |
| `User::where('age', '>', 18)->first()` | `$userRepo->query()->where('age', '>', 18)->first()` |
| `User::where('name', $n)->paginate(15)` | `$userRepo->query()->where('name', $n)->paginate(15)` |

### Persistence

| Active Record | Data Mapper |
|---|---|
| `$user->save()` | `$userRepo->save($user)` |
| `$user->delete()` | `$userRepo->delete($user)` |
| `new User($data); $user->save()` | `new User($data); $userRepo->save($user)` |

### Relations

Relations are loaded explicitly via `with()` on the query builder:

```php
// Active Record (lazy, magic __get)
$user = User::find(1);
$posts = $user->posts; // triggers a query

// Data Mapper (explicit eager loading)
$user = $userRepo->query()->with('posts')->find(1);
$posts = $user->posts; // already loaded
```

Define relations in the repository:

```php
class UserRepository extends AbstractRepository
{
    protected function entityClass(): string
    {
        return User::class;
    }

    /** @return EntityHasMany<Post> */
    protected function posts(): EntityHasMany
    {
        return $this->hasMany(PostRepository::class, Post::class, 'user_id');
    }
}
```

### Soft deletes

Enable by setting `protected static bool $softDeletes = true;` on the entity — same as `Model`.
`AbstractRepository` detects this via `static::hasSoftDeletes()` and applies the `WHERE deleted_at IS NULL`
filter automatically.

### Timestamps

Enable by setting `protected static bool $timestamps = true;` on the entity — same as `Model`.
`AbstractRepository` sets `created_at` on INSERT and `updated_at` on UPDATE automatically.

---

## Casts

The cast configuration is identical between `Model` and `Entity`:

```php
protected static array $casts = [
    'age'        => 'int',
    'score'      => 'float',
    'active'     => 'bool',
    'settings'   => 'json',
    'created_at' => Carbon::class, // must implement CastableInterface
];
```

---

## Testing

Replace `ModelTestCase` with `EzPhp\Testing\DatabaseTestCase` from `ez-php/testing-application`
(dev dependency). It boots the application against the testing database and wraps every test
in a transaction that is rolled back afterwards; pass the bound `DatabaseInterface` to the
repository explicitly:

```php
use App\Repositories\UserRepository;
use EzPhp\Contracts\DatabaseInterface;
use EzPhp\Testing\DatabaseTestCase;

// Before
class UserTest extends ModelTestCase { ... }

// After
final class UserRepositoryTest extends DatabaseTestCase
{
    public function test_find_returns_null_for_missing_id(): void
    {
        $users = new UserRepository($this->app()->make(DatabaseInterface::class));

        $this->assertNull($users->find(999));
    }
}
```

Entity classes can be unit-tested without any database connection:

```php
class UserEntityTest extends TestCase
{
    public function test_fill_sets_fillable_attributes(): void
    {
        $user = new User(['name' => 'Alice', 'email' => 'alice@example.com']);

        $this->assertSame('Alice', $user->name);
        $this->assertSame('alice@example.com', $user->email);
    }
}
```

---

## Migration order

`Model` no longer exists in current `ez-php/orm` releases, so there is no mixed mode on the new
version. Migrate model by model while still on an ORM release that ships `Model` (both
patterns coexist there), then upgrade `ez-php/orm` once no class extends `Model` any more.

---

## Removed / unavailable in Data Mapper

The following Active Record features have no direct equivalent and are intentionally absent:

| Active Record | Reason not in Data Mapper |
|---|---|
| `User::all()` static call | Use `$userRepo->findAll()` |
| Lazy-loaded relations via `$user->posts` (magic, without `with()`) | Lazy loading requires proxy objects; explicit eager loading is preferred |
| `User::create($data)` static factory | Use `new User($data); $userRepo->save($user)` |
| `$user->update($data)` | Use `$user->fill($data); $userRepo->save($user)` |
| Global scopes via `addGlobalScope()` | Not implemented; use explicit query methods in the repository |
| `User::withTrashed()` / `User::onlyTrashed()` static calls | Use `$userRepo->query()->withTrashed()` / `->onlyTrashed()` |
