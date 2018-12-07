FROM php:7.2.0-cli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer clearcache

RUN apt-get update && apt-get install git libcurl4-openssl-dev libssl-dev pkg-config zip zlib1g-dev -y

#### ZIP support
RUN docker-php-ext-install zip

#### MongoDb support
#RUN pecl install mongodb && docker-php-ext-enable mongodb

WORKDIR /var/www/html
CMD ["composer", "install"]

