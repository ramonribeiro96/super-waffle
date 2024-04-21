FROM php:8.2-fpm

WORKDIR /var/www/

RUN apt update && \
    apt upgrade -y && \
    apt install -y libpq-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pdo_pgsql pgsql

CMD [ "php", "-S", "0.0.0.0:8080" ]