<?php

declare(strict_types=1);

return [
    // subdomain, host, header or path — or a comma-separated chain tried in order.
    'resolver' => getenv('TENANCY_RESOLVER') ?: 'subdomain',
    // Base domain of the subdomain resolver: acme.example.com → acme.
    'base_domain' => getenv('TENANCY_BASE_DOMAIN') ?: '',
    // Host resolver: full host => tenant id (custom domains).
    'hosts' => [
        // 'shop.acme.com' => 'acme',
    ],
    'header' => getenv('TENANCY_HEADER') ?: 'X-Tenant',
    'path_segment' => (int) (getenv('TENANCY_PATH_SEGMENT') ?: 0),
    // 404 when no known tenant resolves; false continues without one.
    'required' => filter_var(getenv('TENANCY_REQUIRED') ?: 'true', FILTER_VALIDATE_BOOLEAN),
    // Known tenants: id (lowercase letters, digits, hyphens) => attributes.
    'tenants' => [
        // 'acme' => ['name' => 'Acme Inc.'],
    ],
    // TenantScopedCache keys: <prefix><id>:<key>.
    'cache_prefix' => getenv('TENANCY_CACHE_PREFIX') ?: 'tenant:',
];
