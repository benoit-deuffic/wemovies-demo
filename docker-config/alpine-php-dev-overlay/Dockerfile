FROM composer:latest as composer

FROM bdeuffic/alpine3.13-php-7.4.20-dev-base

# Install packages
RUN apk update \
    && \
    # apt Debian packages
    apk add \
        nano \
        postgresql-dev \
        postgresql-client \
        libxml2 \
        libxml2-dev \
        bash \
        nodejs \
        npm \
    && \
    # Install PHP extensions
    docker-php-ext-install \
        pdo_mysql \
#        pdo_pgsql \
        dom \
        xml \
   && \
   docker-php-ext-enable \
   dom \
   xml \
   && \
   npm install --global yarn 

COPY --from=composer  /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/project/app

ENV PATH=/var/www/project/app/vendor/bin:$PATH
ENV COMPOSER_MEMORY_LIMIT=-1

CMD php-fpm
