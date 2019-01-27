FROM php:7.0-fpm

RUN apt-get update && \
	apt-get install -y libcurl3-dev \
		git \
		zlib1g-dev \
		unzip \
		wget \
		libxslt1-dev \
		libicu-dev \
		libgd-dev

RUN docker-php-ext-install gd pdo_mysql zip xsl intl soap exif bcmath

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php -r "copy('https://composer.github.io/installer.sig', 'installer.sig');" && \
	php -r "if (hash_file('SHA384', 'composer-setup.php') === trim(file_get_contents('installer.sig'))) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); exit(1); } echo PHP_EOL;" && \
	php composer-setup.php --install-dir=/usr/bin --filename=composer --quiet && \
	php -r "unlink('composer-setup.php');"

COPY php.ini /usr/local/etc/php/php.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

RUN useradd -ms /bin/bash -u 1337 user

WORKDIR /var/www

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
