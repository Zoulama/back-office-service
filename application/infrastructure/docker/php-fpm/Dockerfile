FROM php:7.2.0-fpm
RUN mkdir -p /var/www/html
RUN apt-get update && apt-get install -y && \
    apt-get install libcurl4-openssl-dev libssl-dev pkg-config  -y && \
    pecl install mongodb && docker-php-ext-enable mongodb && \
    apt-get install vim -y && \
    #### MySQL support
    docker-php-ext-install pdo pdo_mysql
ADD . /var/www/html
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html



