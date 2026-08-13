FROM php:8.2-cli-alpine

RUN apk add --no-cache \
    git \
    unzip \
    libzip \
    libzip-dev \
    libpng \
    libpng-dev \
    oniguruma \
    oniguruma-dev \
    libxml2 \
    libxml2-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    bcmath \
    zip \
    && apk del libzip-dev libpng-dev oniguruma-dev libxml2-dev

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock* ./

RUN composer install \
    --no-interaction \
    --prefer-dist \
    --no-scripts

COPY . .

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]