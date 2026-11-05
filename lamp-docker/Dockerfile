FROM php:8.2-apache

RUN apt-get update && apt-get install -y     libpng-dev     libjpeg-dev     libfreetype6-dev     zip     unzip     && docker-php-ext-configure gd --with-freetype --with-jpeg     && docker-php-ext-install gd pdo pdo_mysql

RUN a2enmod rewrite

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php/99-development.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/html
