#FROM php:fpm-alpine3.11

FROM php:7.4-fpm-alpine

# Install packages
RUN apk update \
    && \
    # apt Debian packages
    apk add \
        autoconf \
        shadow \
        ca-certificates \
        curl \
        g++ \
        make \
        bzip2-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libpq \
        libressl-dev \
        icu-dev \
        gettext-dev \
        oniguruma-dev \
        libzip-dev \
        imagemagick-dev \
        zlib-dev \
        unzip \
        zip \
        git \
        iputils \
        net-tools \
    && \
    usermod -u 82 www-data && groupmod -g 82 www-data \ 
    && \
    # pecl PHP extensions
    pecl install \
        imagick-3.4.4 \
        redis \
        xdebug-2.8.1 \
        apcu-5.1.18 \
    && \
    # Configure PHP extensions
    docker-php-ext-configure \
        gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && \
    # Install PHP extensions
    docker-php-ext-install \
        bcmath \
        bz2 \
        exif \
        ftp \
        gettext \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        pdo \
        shmop \
        sockets \
        sysvmsg \
        sysvsem \
        sysvshm \
        zip \
        opcache -j$(nproc) \
    && \
    # Enable PHP extensions
    docker-php-ext-enable \
        imagick \
        redis
        
# Append our php.ini overrides to the end of the file
RUN echo "upload_max_filesize = 10M" >> /usr/local/etc/php/php.ini-base && \
    echo "post_max_size = 10M" >> /usr/local/etc/php/php.ini-base && \
    echo "max_execution_time = 300" >> /usr/local/etc/php/php.ini-base && \
    echo "memory_limit = 256M" >> /usr/local/etc/php/php.ini-base && \
    echo "opcache.revalidate_freq = 0" >> /usr/local/etc/php/php.ini-base && \
    echo "opcache.validate_timestamps = 1" >> /usr/local/etc/php/php.ini-base && \
    echo "extension=apcu.so" >> /usr/local/etc/php/php.ini-base && \
    echo "apc.enable=1" >> /usr/local/etc/php/php.ini-base

# Copy the `zzz-docker.conf` file into place for php-fpm
COPY ./zzz-docker.conf /usr/local/etc/php-fpm.d/zzz-docker.conf

