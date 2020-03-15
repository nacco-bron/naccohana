FROM php:7.3-fpm-alpine

# package install
RUN apk update && apk upgrade
RUN apk add php-bcmath php-ctype php-json php-mbstring php-openssl php-pdo php-tokenizer php-xml php-zip
RUN apk add libzip-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
php composer-setup.php && \
php -r "unlink('composer-setup.php');"

COPY php-fpm.conf /usr/local/etc/php-fpm/php-fpm.conf

RUN mv composer.phar /usr/local/bin/composer
# RUN composer global require "laravel/installer=^6.*"

RUN mkdir /var/www/app
WORKDIR /var/www/app