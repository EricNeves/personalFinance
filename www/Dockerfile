FROM php:8.2-fpm-alpine

RUN apk add \
    zip \
    unzip \
    libc-dev \
    libpq-dev \
    libpng-dev \
    jpeg-dev \
    curl \
    make \
    gcc \
    autoconf \
    php-gd \
    bash

RUN pecl install redis

RUN docker-php-ext-enable redis.so \
    && \
    docker-php-ext-install pdo pdo_pgsql gd && \
    docker-php-ext-configure gd --with-jpeg

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . .

COPY php.ini /usr/local/etc/php/conf.d/

RUN composer install

EXPOSE 9000

CMD ["sh", "run.sh"]