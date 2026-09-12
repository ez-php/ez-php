<?php

declare(strict_types=1);

/*
 * Feature flag definitions — read by ez-php/feature-flags' `file` driver.
 *
 * Deliberately outside `config/`: everything in `config/` is loaded by
 * ConfigLoader as a config namespace, so a definitions file there would be
 * read back as its own driver configuration. See `config/flags.php`.
 *
 * Values are cast to bool. Query them with `Flag::enabled('new-checkout')`.
 */

return [
    // 'new-checkout' => true,
    // 'dark-mode' => false,
];
