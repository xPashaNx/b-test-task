FROM php:8.0.13-fpm-alpine

ENV DEPS \
    autoconf \
    g++ \
    libtool \
    pcre-dev

RUN apk update\
    && apk add --no-cache ca-certificates bash make git\
    && apk add --update --no-cache $DEPS \
    # pgsql
    && apk --no-cache add postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql \
    # zip
    && apk add --no-cache libzip-dev openssl-dev\
    && docker-php-ext-configure zip --with-zip=/usr/include \
    && docker-php-ext-install zip \
    # xdebug
    && pecl install xdebug-3.0.1 \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

COPY ./php/php.ini /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /app

EXPOSE 9000
CMD ["php-fpm"]