FROM php:8.4-fpm

WORKDIR "/application"

RUN apt-get update \
    && apt-get install -y make curl libz-dev sshpass unzip zlib1g-dev libssl-dev openssl gnupg libzip-dev mariadb-client \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql opcache

