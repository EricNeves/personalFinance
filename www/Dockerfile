FROM php:8.2-fpm-alpine

RUN apk add \
    zip \
    unzip \
    libc-dev \
    libpq-dev \
    curl \
    bash

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . .

COPY infra/php/php.ini /usr/local/etc/php/conf.d/

RUN composer install

EXPOSE 9000

CMD ["sh", "infra/run.sh"]