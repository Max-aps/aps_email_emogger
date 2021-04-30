FROM php:7.3.0-apache

COPY ./www /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get clean
RUN apt-get update 
RUN apt-get install -y libzip-dev zip 
RUN docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip

WORKDIR /var/www/html

RUN composer install

EXPOSE 80
