FROM php:7.4-apache
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
