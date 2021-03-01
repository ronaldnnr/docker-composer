FROM php:7.3-apache
RUN pecl install redis && docker-php-ext-enable redis 
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo_mysql
#RUN docker-php-ext-install mysqli
