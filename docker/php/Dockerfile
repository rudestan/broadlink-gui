FROM php:7.1.9-fpm

RUN apt-get update \
    && apt-get install -y \
        curl \
        wget \
        git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libicu-dev \
        libicu52  \
    && docker-php-ext-install iconv \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install intl \
    && docker-php-ext-install opcache

COPY php.ini        /usr/local/etc/php/conf.d/
COPY default.conf    /usr/local/etc/php-fpm.d/www.conf


COPY docker-entry-point /usr/local/bin/

ENTRYPOINT ["docker-entry-point"]

USER  www-data

CMD ["php-fpm"]

EXPOSE 9000
