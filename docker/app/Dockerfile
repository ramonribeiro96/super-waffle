FROM php:8.2-fpm

WORKDIR /tmp/

RUN apt update && \
    apt upgrade -y && \
    apt install -y libpq-dev wget zip && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pdo_pgsql pgsql

RUN wget https://getcomposer.org/download/2.7.4/composer.phar && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

WORKDIR /var/www/

CMD [ "php", "-S", "0.0.0.0:8080" ]