#!/usr/bin/env bash

# Run PHP-FPM as current user
if [ ! -z "$WWWUSER" ]; then
	echo $WWWUSER
	sed -i "s/user\ \=.*/user\ \= $WWWUSER/g" /usr/local/etc/php-fpm.d/www.conf

	usermod -u $WWWUSER user
else
	echo "nope"
fi

if [ ! -d /.composer ]; then
    mkdir /.composer
fi
chmod -R ugo+rw /.composer

if [ $# -gt 0 ]; then
	exec su -c "$@" $WWWUSER
else
	/usr/local/sbin/php-fpm
fi
