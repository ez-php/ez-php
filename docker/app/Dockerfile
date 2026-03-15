FROM php:8.5-fpm

ARG WWWUSER=1000
ARG WWWGROUP=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git unzip zip curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Install Redis PHP extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create non-root user
RUN groupadd -g ${WWWGROUP} sail \
    && useradd -u ${WWWUSER} -ms /bin/bash -g sail sail

# Copy PHP config
COPY docker/app/php.ini /usr/local/etc/php/conf.d/99-custom.ini

# Copy Nginx config
COPY docker/app/nginx.conf /etc/nginx/sites-available/default

# Copy Supervisor config
COPY docker/app/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy start script
COPY docker/app/container-start.sh /usr/local/bin/container-start.sh
RUN chmod +x /usr/local/bin/container-start.sh

# Git x Composer fix
RUN git config --global --add safe.directory '*'

WORKDIR /var/www/html

EXPOSE 80/tcp

CMD ["/usr/local/bin/container-start.sh"]
