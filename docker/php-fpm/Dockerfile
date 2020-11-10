FROM php:7.4-fpm

MAINTAINER livalex

RUN set -eux; \
	apt-get update; \
	apt-get install -y gosu; \
	rm -rf /var/lib/apt/lists/*; \
	gosu nobody true

## Create user for files
RUN groupadd -g 1000 www \
    && useradd -u 1000 -g www -g www-data www

RUN apt-get update \
    && apt-get install -y locales \
    && apt-get -y dist-upgrade

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    supervisor \
    software-properties-common \
    && apt-get update \
    && apt-get install -y \
        wget make autoconf libc-dev pkg-config g++ \
        zlib1g-dev libicu-dev libmcrypt-dev libmemcached-dev libmcrypt-dev libgeoip-dev libbz2-dev libssl-dev \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev libc-client-dev libkrb5-dev libzip-dev \
        libcurl4-gnutls-dev libxml2-dev libxslt-dev libsasl2-2 sasl2-bin libsasl2-2 libsasl2-dev libsasl2-modules \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN apt-get update \
    && pecl channel-update pecl.php.net \
    && pecl install memcached apcu redis geoip-1.1.1 mcrypt memcache \
    && docker-php-ext-configure gd --with-jpeg --with-freetype  \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install bcmath \
        bz2 \
        intl \
        -j$(nproc) gd \
        pdo \
        pdo_mysql \
        mysqli \
        opcache \
        imap \
        zip \
        curl \
#        mbstring \
        fileinfo \
        pcntl \
        exif \
        shmop \
        gettext \
        soap \
        sockets \
        xsl \
        xmlrpc \
    && docker-php-ext-enable apcu bcmath bz2 memcached gd redis geoip pdo_mysql mcrypt memcache \
    && rm -rf /tmp/pear

RUN apt-get remove -y --purge software-properties-common \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY php-fpm.conf /etc/php/7.4/fpm/php-fpm.conf
COPY www.conf /etc/php/7.4/fpm/pool.d/www.conf

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm"]
