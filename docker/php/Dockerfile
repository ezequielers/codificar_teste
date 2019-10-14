FROM php:7.3.5-fpm
MAINTAINER Ezequiel Schneider da Silva <ezequielrs@gmail.com>

RUN echo 'deb http://httpredir.debian.org/debian jessie contrib' >> /etc/apt/sources.list

RUN apt-get update
RUN export DEBIAN_FRONTEND=noninteractive && apt-get install -y --force-yes libssl-dev curl zip unzip libcurl4-gnutls-dev libxml2-dev libicu-dev libmcrypt4 libmemcached11 openssl
RUN apt-get install -y --no-install-recommends git zip curl

#LIBS EXTRAS
RUN docker-php-ext-install bcmath
RUN apt-get install -y libbz2-dev
RUN docker-php-ext-install bz2
RUN docker-php-ext-install mbstring
RUN apt-get install -y libpq-dev
RUN apt-get install -y libicu-dev
RUN docker-php-ext-install intl

#GD
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng16-16
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd

#PDO - CUSTOMIZAR A SEU DISPOR
RUN docker-php-ext-install mysqli pdo_mysql

RUN docker-php-ext-enable intl

RUN echo "date.timezone=\"America/Sao_Paulo\"" >> /usr/local/etc/php/conf.d/timezone.ini

EXPOSE 9000
CMD ["php-fpm"]