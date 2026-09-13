---
description: Audit this application (scaffolded from the ez-php/ez-php template) for structural correctness, config completeness, and drift between the project's CLAUDE.md and its actual code. Findings go to TODO.md.
---

# Audit: Application Structure & Config

Audit this application — scaffolded from the `ez-php/ez-php` template per `NEW_PROJECT.md` — for structural correctness, config completeness, and drift between this project's own `CLAUDE.md` and its actual code. Write all findings to `TODO.md` (create it if it doesn't exist yet).

This is **not** the monorepo audit suite. `/audit`, `/audit-backend`, `/audit-modules`, and `/audit-architecture` (if present) check a multi-package framework repo — `modules/*/`, `packages.sh`, per-package CI. This application has none of that: it is a single Composer project with `ez-php/framework` and selected `ez-php/*` packages installed as vendor dependencies. Audit what this repo actually contains — `app/`, `config/`, `provider/`, `routes/`, `database/`, `tests/` — not framework/module internals living in `vendor/`.

## What to audit

### 1. Provider wiring
- `provider/core.php` must be untouched — the kernel loads the 7 core providers via `CoreServiceProviders::all()`, not from this file's contents; flag any edit that suggests someone tried to reorder or remove a core provider here.
- Every commented-out or missing line in `provider/modules.php` for a package that **is** in `composer.json` `require` is a bug (installed but not wired up) — cross-check against each module's `README.md`/`ez-php/docs/CONFIG.md` for whether it needs a provider at all (e.g. `ez-php/scheduler` registers manually, `ez-php/support` needs none).
- Every uncommented provider line for a package that is **not** in `composer.json` `require` is dead config — flag for removal.
- `App\Providers\AppServiceProvider` must stay last in `provider/modules.php`.

### 2. Config completeness
For each `ez-php/*` package actually in `composer.json` `require`:
- A matching `config/<name>.php` exists if the module needs one (check the module's own `README.md` / `ez-php/docs/CONFIG.md` for its config keys).
- Every key the config file reads via `getenv()` has a corresponding entry in `.env.example` (and ideally `.env`).

For each `config/*.php` file present:
- Flag it if the corresponding `ez-php/*` package is **not** in `composer.json` `require` — an unused config file is a claim the application does not honor (see `NEW_PROJECT.md` §4).

### 3. Routes & Controllers
- Every route handler in `routes/web.php` references a `Controller` class/method that actually exists.
- Controllers and Middleware use constructor injection — flag any service-locator-style resolution (`$app->make()`, static facades called from inside a constructor) instead of a typed constructor parameter.
- If `CsrfMiddleware` is registered as global middleware, a `CsrfTokenStoreInterface` binding must exist in some provider — flag its absence (this throws `ContainerException` at request time otherwise).

### 4. Migrations & Database
- Every file under `database/migrations/` returns an anonymous class implementing `MigrationInterface` with both `up(PDO $db)` and `down(PDO $db)`.
- Cross-check tables/columns referenced by `app/Entities/`, `app/Repositories/`, or `app/Models/` against what the migrations actually create — flag an Entity/Model that assumes a column no migration creates.

### 5. Tests
- Every test class extends the appropriate base from `ez-php/testing-application` (`ApplicationTestCase`, `DatabaseTestCase`, `HttpTestCase`) per `ez-php/docs/testing-guide.md` — flag a bare `PHPUnit\Framework\TestCase` extension instead.
- Each Controller and each custom Middleware has at least one corresponding test.

### 6. This project's own CLAUDE.md
- The part before the `---` separator must still read as `CODING_GUIDELINES.md` content (verbatim copy, per `NEW_PROJECT.md` §3) — if a copy of the monorepo's current `CODING_GUIDELINES.md` is available for comparison, diff them; otherwise just check internal consistency (no leftover template-specific wording).
- The `# Project: <name>` section must accurately reflect reality: **Active modules** matches `composer.json` `require`, **Source structure** matches the actual `app/` tree, **Testing approach** matches what's actually used in `tests/`.

### 7. Template leftovers not cleaned up
Per `NEW_PROJECT.md` §2 and the checklist in §7, flag if still present:
- `CHANGELOG.md`, `cliff.toml` (unless deliberately kept for this project's own releases)
- `.github/workflows/` still written for the template, not adapted
- `bin/setup` and the `post-create-project-cmd` script in `composer.json` still present after first setup
- `docker-compose.yml` `container_name` entries still reading `ez-php-template-*`
- `.env` tracked by git (check `.gitignore` and `git ls-files`)

## Output format

Append to `TODO.md` under a new section:

```markdown
## Application Audit — YYYY-MM-DD

### Summary
- Areas checked: N  |  Items found: N

### Provider & Config Issues
- [ ] [P1] Short description — `path/to/file` — Acceptance criteria

### Routes & Controllers
- [ ] [P2] ...

### Migrations & Data
- [ ] [P2] ...

### Missing Tests
- [ ] [P3] ...

### CLAUDE.md Drift
- [ ] [P3] ...

### Template Leftovers
- [ ] [P4] ...
```

Priority scale:
- **P1** — Installed module not wired up (or vice versa), missing CSRF store binding, or any issue that breaks the app at boot/request time
- **P2** — Broken route/controller reference, service-locator usage, migration/entity mismatch
- **P3** — Missing test, stale `CLAUDE.md` project section
- **P4** — Leftover template file, cosmetic config drift

## Rules

- Do NOT implement any fixes — audit only, write findings only.
- Check only what this repository actually contains — do not go looking for `modules/*/` or `framework/src/`; those live in `vendor/` and are out of scope here.
- Every item must reference the specific file (and line number where applicable).
- Do NOT add vague items — every item must be specific and actionable.
- If `TODO.md` already exists, append a new dated section rather than overwriting.
- When done, report how many items were found per priority level.
