ARG SYMFONY_SKIP_REGISTRATION=1
FROM php:8.4-fpm as php-fpm

LABEL maintainer="Marçal Berga"

RUN apt-get update && apt-get install -y \
  unzip \
  libicu-dev \
  zlib1g-dev \
  libzip-dev \
  libpq-dev \
  libonig-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-install \
  intl \
  mbstring \
  opcache \
  pdo \
  zip

WORKDIR /var/www/html/public

COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

FROM php-fpm as dev

RUN pecl install xdebug
COPY docker/php/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

EXPOSE 9000
CMD ["php-fpm"]