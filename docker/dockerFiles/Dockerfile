FROM composer:2.0 as composer

COPY ./app/composer.json /app
RUN composer require phpunit/phpunit
RUN composer install

FROM php:7.4-apache
COPY --from=composer /app /composer

## git, unzip & zip are for composer
RUN apt-get update -qq && \
    apt-get install -qy \
    gnupg \
    unzip \
    libpq-dev \
    zlib1g-dev \
    zip

## PHP Conf
COPY docker/conf/php.ini /usr/local/etc/php/conf.d/app.ini

COPY ./inc/entrypoint.sh /entrypoint.sh
