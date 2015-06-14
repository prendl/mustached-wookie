#!/bin/sh

# fix cron entries
chown root:root /etc/cron.d/*
chmod 600 /etc/cron.d/*

/usr/local/sbin/php-fpm >> /var/log/php-fpm.log 2>&1
