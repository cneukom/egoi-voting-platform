FROM php:8.0-apache

COPY --chown=www-data:www-data . /var/www/app

WORKDIR /var/www/app

ENV APACHE_DOCUMENT_ROOT /var/www/app/public

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN a2enmod rewrite

# When changing the numbers of servers, don't forget to adapt the Pod's memroy limits!

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update \
    && apt-get install -y libzip-dev zip libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install opcache
COPY opcache.ini "$PHP_INI_DIR/conf.d/opcache.ini"

# install package management utils
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sL https://deb.nodesource.com/setup_15.x | bash - \
    && apt-get install -y nodejs

# install dependencies & build frontend
RUN composer install --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader \
    && npm install \
    && npm run prod
