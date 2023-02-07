FROM php:8.1-apache

RUN mkdir /var/app
RUN chown www-data:www-data /var/app

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y nano
RUN apt-get install -y zip

RUN apt-get update && apt-get -y --no-install-recommends install \
    git \
    curl \
    libicu-dev \
    libonig-dev \
    libpng-dev \
    libwebp-dev \
    libxml2-dev \
    zip \
    nano \
    unzip \
    supervisor \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpq-dev \
    libzip-dev \
    libxslt-dev \
    && apt-get autoremove --purge -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ --with-webp=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install -j$(nproc) \
    intl \
    exif \
    pcntl \
    bcmath

RUN pecl install apcu
RUN docker-php-ext-enable apcu

COPY docker/develop/files/php/php.ini /usr/local/etc/php/

RUN curl -sS https://getcomposer.org/installer | \
php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p "/etc/supervisor/logs"
ADD docker/develop/app/supervisor.conf /etc/supervisor/conf.d/worker.conf

#RUN apt-get install -y imagemagick

RUN ln -s /etc/apache2/mods-available/expires.load /etc/apache2/mods-enabled/expires.load
RUN ln -s /etc/apache2/mods-available/headers.load /etc/apache2/mods-enabled/headers.load
RUN ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load
RUN ln -s /etc/apache2/mods-available/ssl.load /etc/apache2/mods-enabled/ssl.load
COPY docker/develop/files/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

ENV APACHE_DOCUMENT_ROOT /var/app/public
RUN sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN docker-php-ext-install -j$(nproc) intl

#RUN docker-php-ext-install -j$(nproc) mbstring

RUN docker-php-ext-install -j$(nproc) opcache

RUN docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install -j$(nproc) pgsql
RUN docker-php-ext-install -j$(nproc) pdo_pgsql

RUN docker-php-ext-install -j$(nproc) xsl


RUN docker-php-ext-install -j$(nproc) zip

RUN yes | pecl install xdebug && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/app
COPY . /var/app

RUN composer update

EXPOSE 80
