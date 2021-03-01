FROM php:7.4-apache
MAINTAINER Ronald Gonzaga da Silva <ronaldnnr@gmail.com>

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update													&& \
	echo "locales locales/locales_to_be_generated multiselect pt_BR ISO-8859-1" | debconf-set-selections		&& \
	echo "locales locales/default_environment_locale select pt_BR" | debconf-set-selections				&& \
	apt-get install --no-install-recommends -q -y locales apt-utils wget gnupg2 ca-certificates telnet iputils-ping	&& \
	rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*                                                                   && \
        docker-php-ext-install mysqli && docker-php-ext-enable mysqli                                                   && \
        pecl install redis && docker-php-ext-enable redis

ENV LC_ALL pt_BR


