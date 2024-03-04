FROM php:7.4.16-fpm-alpine3.13
## Utilities
RUN apk add --no-cache \
    zip \
    zlib-dev \
    git;
##===================================================
## Node & Gulp
##===================================================
RUN apk add --no-cache --update nodejs npm keychain
RUN npm install --global yarn
#RUN wget https://www.imagemagick.org/download/ImageMagick.tar.gz
#RUN apk add --no-cache autoconf g++ make
#RUN tar xvzf ImageMagick.tar.gz && \
#   cd ImageMagick-7.0.* && \
#   ./configure --with-webp=yes --with-jpeg=yes --with-openjp2=yes --with-png=yes --with-tiff=yes && \
#   make && \
#   make install;
##===================================================
## PHP
##===================================================
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions \
    zip \
    mysqli \
    intl \
    pdo_mysql \
    gd \
    bz2 \
    imagick \
    @composer \
    bcmath \
    xdebug-3.0.2 \
    mcrypt \
    sodium \
    sockets;
#RUN install-php-extensions opcache

ARG USER_ID
ARG GROUP_ID
RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
    deluser www-data &&\
    if getent group www-data ; then delgroup www-data; fi &&\
    addgroup -g ${GROUP_ID} -S www-data; \
    adduser -D -u ${USER_ID} -S -G www-data www-data \
    ;fi
COPY ./config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./config/php.ini $PHP_INI_DIR/php.ini

#RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
#    chmod +x wp-cli.phar && \
#    mv wp-cli.phar /usr/local/bin/wp

WORKDIR /src