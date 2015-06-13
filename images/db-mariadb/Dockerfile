# Use phusion/baseimage as base image. To make your builds
# reproducible, make sure you lock down to a specific version, not
# to `latest`! See
# https://github.com/phusion/baseimage-docker/blob/master/Changelog.md
# for a list of version numbers.
FROM phusion/baseimage:0.9.16

# Use baseimage-docker's init system.
CMD ["/sbin/my_init"]

# add our user and group first to make sure their IDs get assigned consistently, regardless of whatever dependencies get added
RUN groupadd -r mysql && useradd -r -g mysql mysql

RUN apt-key adv --keyserver ha.pool.sks-keyservers.net --recv-keys 199369E5404BD5FC7D2FE43BCBCB082A1BB943DB

ENV MARIADB_MAJOR 10.0
ENV MARIADB_VERSION 10.0.19+maria-1~trusty

RUN echo "deb http://ftp.osuosl.org/pub/mariadb/repo/$MARIADB_MAJOR/ubuntu trusty main" > /etc/apt/sources.list.d/mariadb.list \
	&& { \
		echo 'Package: *'; \
		echo 'Pin: release o=MariaDB'; \
		echo 'Pin-Priority: 999'; \
	} > /etc/apt/preferences.d/mariadb
# add repository pinning to make sure dependencies from this MariaDB repo are preferred over Debian dependencies
#  libmariadbclient18 : Depends: libmysqlclient18 (= 5.5.42+maria-1~trusty) but 5.5.43-0+deb7u1 is to be installed

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
	mariadb-server=$MARIADB_VERSION \
	&& rm -rf /var/lib/mysql \
	&& mkdir /var/lib/mysql \
	&& sed -ri 's/^(bind-address|skip-networking)/;\1/' /etc/mysql/my.cnf

# Clean up APT when done.
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/mysql.log
RUN ln -sf /dev/stderr /var/log/mysql.err

RUN mkdir /etc/service/mariadb
ADD mariadb.sh /etc/service/mariadb/run
RUN chmod +x /etc/service/mariadb/run

VOLUME ["/var/lib/mysql"]

EXPOSE 3306

WORKDIR /
