FROM php:8.1.0-fpm
WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    zip \
    libzip-dev \
    unzip

COPY composer.json .
COPY composer.lock .
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
