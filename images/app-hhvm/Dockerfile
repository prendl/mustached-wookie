FROM brunoric/hhvm:deb

ENV LC_ALL=C.UTF-8

RUN \
  apt-get update \
  && apt-get install -y --no-install-recommends git

RUN \
  mkdir -p /usr/local/bin \
  && cd /usr/local/bin \
  && php -r "readfile('https://getcomposer.org/installer');" | php \
  && mv composer.phar composer

VOLUME ["/etc/hhvm", "/var/www"]

WORKDIR /var/www
