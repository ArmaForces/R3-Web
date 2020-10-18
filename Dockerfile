FROM php:7.4-apache as r3_web

RUN a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql
