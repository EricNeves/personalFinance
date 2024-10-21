FROM php:8.2-fpm-alpine

RUN apk add \
    zip \
    unzip \
    libc-dev \
    libpq-dev \
    libpng-dev \
    curl \
    make \
    gcc \
    autoconf

RUN pecl install redis

RUN docker-php-ext-enable redis.so \
    && \
    docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . .

RUN composer install

EXPOSE 9000

CMD ["php-fpm"]