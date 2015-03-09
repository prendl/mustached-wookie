FROM php:5.6-fpm

ENV LC_ALL=C.UTF-8

RUN \
  apt-get update \
  && apt-get install -y --no-install-recommends git libicu52 libpng12-0 libgd3

RUN \
  mkdir -p /usr/local/bin \
  && cd /usr/local/bin \
  && php -r "readfile('https://getcomposer.org/installer');" | php \
  && mv composer.phar composer

WORKDIR /var/www
