FROM php:7.3-fpm-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add shadow \
    icu-dev \
    libzip-dev \
    && docker-php-ext-install iconv \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install intl \
    && docker-php-ext-install opcache \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets

RUN usermod -u 1000 www-data
RUN sed -i "s/listen =.*/listen = 0.0.0.0:9000/" /usr/local/etc/php-fpm.d/www.conf \
    && mkdir -p /var/run/php

COPY php.ini        /usr/local/etc/php/conf.d/
