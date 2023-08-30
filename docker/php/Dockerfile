FROM php:7.2-fpm-alpine

RUN addgroup -g 1000 developer \
    && adduser -u 1000 -D -h /home/developer -G developer -s /bin/sh developer

## php libraries
ENV MEMCACHED_DEPS zlib-dev libmemcached-dev cyrus-sasl-dev
ENV GD_DEPS freetype-dev libpng-dev libjpeg-turbo-dev

RUN apk update \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
        && apk add --no-cache --update --virtual .memcached-deps $MEMCACHED_DEPS \
        && apk add --no-cache --update --virtual .gd-deps $GD_DEPS \
        && apk add --no-cache \
            icu-dev \
            postgresql-dev \
            libxml2-dev \
            libmcrypt-dev \
            libmemcached-libs zlib \
            freetype libpng libjpeg-turbo \
            graphviz font-noto \
            ssmtp

RUN apk add --no-cache --virtual .imagick-build-dependencies \
  autoconf \
  curl \
  g++ \
  gcc \
  git \
  imagemagick-dev \
  libtool \
  make \
  tar \
  openssh-client \
&& apk add --virtual .imagick-runtime-dependencies \
  imagemagick

RUN apk add bash \
  && apk add mc

RUN apk add --no-cache php7-pear php7-dev gcc musl-dev make
RUN pecl install imagick \
  && echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini

RUN docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd sockets \
#    && pecl install memcached redis xdebug \
#    && docker-php-ext-enable memcached \
#    && docker-php-ext-enable redis \
#    && docker-php-ext-enable xdebug \
    && docker-php-ext-install \
        intl \
        opcache \
        mysqli pdo_mysql \
        pgsql pdo_pgsql \
        zip \
        bcmath

RUN apk update && apk add libxml2-dev php-soap && docker-php-ext-install soap

## composer
RUN mkdir /home/developer/.composer
#COPY ./composer.json /home/developer/.composer/composer.json
RUN chown -R developer:developer /home/developer/.composer

RUN wget https://getcomposer.org/installer -P /home/developer
RUN php -f /home/developer/installer args --version="1.10.10" --install-dir="/usr/local/bin" --filename="composer"
RUN chmod +x /usr/local/bin/composer && rm /home/developer/installer

## copy enviroment
COPY ./php-fpm.ini /usr/local/etc/php/
#COPY ./www.conf /usr/local/etc/php/

USER developer

WORKDIR /var/www
#FROM php:7.4-fpm
##FROM php:8.1-fpm
#
#ARG USERNAME=developer
#ARG USER_UID=1000
#ARG USER_GID=$USER_UID
#
## Create the user
#RUN groupadd --gid $USER_GID $USERNAME \
#    && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME
#
#RUN apt-get update -q -y \
#    && apt-get install -q -y --no-install-recommends \
#    libmemcached-dev zlib1g-dev \
#    curl \
#    libpq-dev \
#    libzip-dev \
#    libpng-dev \
#    zip \
#    libmcrypt-dev \
#    unzip \
#    git \
#    supervisor \
#    procps \
#    sudo \
#    redis-server \
#    && pecl install memcached \
#    && pecl install ds \
#    && pecl install redis \
#    && docker-php-ext-enable redis \
#    && docker-php-ext-enable memcached \
#    && rm -rf /var/lib/apt/lists/*
#
#RUN apt-get update -q -y \
#    && apt-get install -q -y --no-install-recommends \
#    libzip-dev \
#    zip \
#    psmisc
#
#RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
#    && docker-php-ext-install pgsql pdo_pgsql \
#    && docker-php-ext-install bcmath \
#    && docker-php-ext-install zip \
#    && pecl install xdebug \
#    && docker-php-ext-enable xdebug \
#    && docker-php-ext-install sockets
#
#ADD php-fpm.ini /usr/local/etc/php/php.ini
#
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN pear install PHP_CodeSniffer
#
#USER $USERNAME
#
#WORKDIR /var/www