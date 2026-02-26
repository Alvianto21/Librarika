# Declaration PHP extension
ARG PHP_EXTS="curl intl mbstring exif bcmath pdo pdo_mysql opcache zip"

ARG PHP_SYS="zip unzip git cron libzip-dev libfreetype-dev libjpeg62-turbo-dev libpng-dev libonig-dev libcurl4-openssl-dev libicu-dev"
# Starting base
FROM composer:2.8.11 AS composer_base


RUN mkdir -p /opt/apps/laravel_kubernetes /opt/apps/laravel_kubernetes/bin

WORKDIR /opt/apps/laravel_kubernetes

# Set composer group and user
RUN addgroup -S composer && adduser -S composer -G composer \
    && chown -R composer /opt/apps/laravel_kubernetes 

USER composer

COPY --chown=composer composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --no-scripts --no-autoloader \
    --prefer-dist --no-interaction --ignore-platform-reqs

COPY --chown=composer . .

# Install scripts
RUN composer install --no-dev --prefer-dist --optimize-autoloader \
    --ignore-platform-reqs

# Frontend base 
FROM node:22 AS frontend

COPY --from=composer_base /opt/apps/laravel_kubernetes /opt/apps/laravel_kubernetes

WORKDIR /opt/apps/laravel_kubernetes

# Install NPM packages
COPY package.json package-lock.json ./

RUN npm install ci && npm run build

# CLI controller base
FROM php:8.3.26-cli AS cli

ARG PHP_EXTS
ARG PHP_SYS

WORKDIR /opt/apps/laravel_kubernetes

# Install PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    --no-install-suggests ${PHP_SYS} openssl ca-certificates ${PHP_SYS} \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd ${PHP_EXTS} \
    && docker-php-ext-enable ${PHP_EXTS} \
    && rm -rf /var/cache/apk/* && apt-get clean

COPY --from=composer_base /opt/apps/laravel_kubernetes /opt/apps
COPY --from=frontend /opt/apps/laravel_kubernetes/public /opt/apps/laravel_kubernetes/public

# PHP main base
FROM php:8.3.26-fpm AS fpm_server

WORKDIR /var/www/html

ARG PHP_EXTS
ARG PHP_SYS

# Install PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    --no-install-suggests ${PHP_SYS} openssl ca-certificates ${PHP_SYS} \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd ${PHP_EXTS} \
    && docker-php-ext-enable ${PHP_EXTS} \
    && rm -rf /var/cache/apk/* && apt-get clean

COPY --from=composer_base --chown=www-data /opt/apps/laravel_kubernetes /var/www/html/
COPY --from=frontend --chown=www-data /opt/apps/laravel_kubernetes/public /var/www/html/public
COPY ./docker/php/php.ini $PHP_INI_DIR/conf.d/

# ensure entrypoint is executable
RUN chmod +x /var/www/html/docker/entrypoint.sh

USER www-data

COPY --chown=www-data . .

# Only use this if caches broken, otherwise remove it
RUN rm -f bootstrap/cache/*.php \
    rm -rf storage/framework/cache/* \
    rm -rf storage/framework/views/*

ENTRYPOINT [ "docker/entrypoint.sh" ]

CMD [ "php-fpm" ]

# Nginx for web server
FROM nginx:1.29 AS web_server

WORKDIR /var/www/html

COPY ./docker/nginx/nginx.conf /etc/nginx/templates/default.conf.template
COPY --from=frontend /opt/apps/laravel_kubernetes/public/ /var/www/html/public/

# Cron job base
FROM cli AS cron

WORKDIR /opt/apps/laravel_kubernetes

# Setup cronjob
RUN touch laravel.cron && \
    echo "* * * * * cd /opt/apps/laravel_kubernetes && php artisan schedule:run >> /proc/1/fd/1 2>/proc/1/fd/2" >> laravel.cron \
    crontab laravel.cron

CMD [ "cron", "-f" ]

FROM cli AS default