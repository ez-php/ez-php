# ez-php

Application template for [ez-php](https://github.com/ez-php/framework) — a lightweight, modular PHP framework.

## Requirements

- PHP 8.5+
- Composer
- Docker (recommended)

## Getting Started

```bash
cp .env.example .env
composer install
docker compose up -d
php ez migrate
```

## Quality Suite

```bash
composer full       # PHPStan + CS Fixer + PHPUnit
composer analyse    # PHPStan only
composer cs         # CS Fixer only
composer test       # PHPUnit only
```
