#!/bin/sh

set -e

cd /var/www/html

composer install --no-interaction --prefer-dist --optimize-autoloader

exec /usr/bin/supervisord
