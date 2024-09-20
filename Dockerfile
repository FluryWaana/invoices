FROM php:8.3-fpm-alpine

RUN apk add --no-cache bash git curl libpng-dev libjpeg-turbo-dev freetype-dev oniguruma-dev libxml2-dev zip unzip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
