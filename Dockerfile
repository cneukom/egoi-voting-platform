FROM docker.dolansoft.org/egoi/php-docker-base-image:master

COPY --chown=www-data:www-data . /var/www/app

# install dependencies & build frontend
RUN composer install --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader \
    && npm install \
    && npm run prod
