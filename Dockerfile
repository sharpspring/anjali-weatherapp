FROM php:5.6-fpm

RUN docker-php-ext-install pdo_mysql

COPY php.ini /usr/local/etc/php

COPY  src/ /var/www/site