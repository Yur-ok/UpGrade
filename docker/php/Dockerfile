FROM php:8.1-fpm

ARG USERNAME=developer
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# Create the user
RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME

RUN apt-get update -q -y \
    && apt-get install -q -y --no-install-recommends \
    libmemcached-dev zlib1g-dev \
    curl \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    zip \
    libmcrypt-dev \
    unzip \
    git \
    supervisor \
    procps \
    sudo \
    redis-server \
    && pecl install memcached \
    && pecl install ds \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable memcached \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update -q -y \
    && apt-get install -q -y --no-install-recommends \
    libzip-dev \
    zip \
    psmisc

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install zip \
    && pecl install xdebug-3.2.2 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install sockets

ADD php-fpm.ini /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN pear install PHP_CodeSniffer

USER $USERNAME

WORKDIR /var/www