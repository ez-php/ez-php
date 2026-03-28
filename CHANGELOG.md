# Changelog

All notable changes to `ez-php/ez-php` are documented here.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

---

## [v1.1.0] — 2026-03-28

### Added
- `bin/setup` — interactive project installer; runs via `post-create-project-cmd` after `composer create-project`; presents a numbered list of optional modules, runs `composer require` for selected packages, and auto-uncomments providers in `provider/modules.php`
- `lang/fr/validation.php`, `lang/es/validation.php`, `lang/it/validation.php`, `lang/pt/validation.php`, `lang/nl/validation.php`, `lang/pl/validation.php` — validation error message translations for French, Spanish, Italian, Portuguese, Dutch, and Polish

### Changed
- `provider/modules.php` — added commented-out entries for `ez-php/notification`, `ez-php/storage`, `ez-php/health`, and `ez-php/feature-flags`

---

## [v1.0.1] — 2026-03-25

### Changed
- Tightened all `ez-php/*` dependency constraints from `"*"` to `"^1.0"` for predictable resolution

---

## [v1.0.0] — 2026-03-24

### Added
- Application template for bootstrapping new ez-php projects
- `public/index.php` — HTTP entry point: loads `.env`, builds `Request` from superglobals, bootstraps the application, handles the request, and emits the response
- `ez` — CLI entry point: loads `.env`, bootstraps the application, and runs the `Console` dispatcher with `$argv`
- Pre-configured directory layout: `app/Controllers`, `app/Middleware`, `app/Models`, `app/Providers`, `config/`, `database/migrations/`, `lang/`, `provider/`, `routes/`, `public/`
- `provider/core.php` — ordered list of the six core service providers (do not reorder)
- `provider/modules.php` — optional module providers; add or remove entries to enable/disable packages
- `routes/web.php` — route definition file pre-wired into the router service provider
- `config/app.php`, `config/db.php`, `config/cache.php` — environment-backed config files for application, database, and cache settings
- `lang/en/validation.php` and `lang/de/validation.php` — built-in validation message translations
- `docs/getting-started.md` — zero-to-running guide for new applications
- `docs/CONFIG.md` — central reference for all `.env` / config keys across every module
- `docs/testing-guide.md` — test base classes, patterns, and infrastructure setup
