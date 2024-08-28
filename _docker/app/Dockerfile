FROM php:8.3.6-fpm-alpine3.19

RUN apk update && apk add \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git \
      autoconf \
      gcc \
      g++ \
      make \
      musl-dev
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install pdo_pgsql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip
RUN pecl install redis && docker-php-ext-enable redis
RUN apk cache clean && \
      rm -rf /var/cache/apk/* /tmp/*  /var/tmp/* \

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /var/www

