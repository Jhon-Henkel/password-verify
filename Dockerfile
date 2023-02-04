FROM php:8.1.11-apache

COPY . .

RUN apt-get update && apt-get -y --no-install-recommends install git \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-install zip

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && pecl install xdebug

RUN composer update