FROM php:8.5-fpm AS fpm

FROM au9500/php:8.5

# Copy php-fpm binary and config from official fpm image
COPY --from=fpm /usr/local/sbin/php-fpm /usr/local/sbin/php-fpm
COPY --from=fpm /usr/local/etc/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY --from=fpm /usr/local/etc/php-fpm.d/ /usr/local/etc/php-fpm.d/

# Install nginx and supervisor
RUN apt-get update && apt-get install -y nginx supervisor \
    && rm -rf /var/lib/apt/lists/*

# Copy Nginx config
COPY docker/app/nginx.conf /etc/nginx/sites-available/default

# Copy Supervisor config
COPY docker/app/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy start script
COPY docker/app/container-start.sh /usr/local/bin/container-start.sh
RUN chmod +x /usr/local/bin/container-start.sh

WORKDIR /var/www/html

EXPOSE 80/tcp

CMD ["/usr/local/bin/container-start.sh"]
