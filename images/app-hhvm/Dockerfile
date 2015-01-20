FROM brunoric/hhvm:base

ENV HHVM_VERSION HHVM-3.5.0
ENV CORE_NUMBER 1

# workaround error "function strtonum never defined"
RUN apt-get install gawk

# Building HHVM
WORKDIR /hhvm-repo
RUN git fetch
RUN git checkout tags/${HHVM_VERSION}
RUN git submodule update --init --recursive
RUN cmake . && make -j ${CORE_NUMBER} && make install

# Removing the pulled repository
WORKDIR /
RUN rm -rf hhvm-repo

# Exposing HHVM-FastCGI port
EXPOSE 9000

# Default command
CMD ["/scripts/start.sh"]

ENV LC_ALL=C.UTF-8

RUN \
  apt-get update \
  && apt-get install -y --no-install-recommends git

RUN \
  mkdir -p /usr/local/bin \
  && cd /usr/local/bin \
  && ln -s hhvm php \
  && php -r "readfile('https://getcomposer.org/installer');" | php \
  && mv composer.phar composer

VOLUME ["/etc/hhvm", "/var/www"]

WORKDIR /var/www
