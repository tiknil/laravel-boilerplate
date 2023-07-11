#
#--------------------------------------------------------------------------
# Image Setup
#--------------------------------------------------------------------------
#

FROM php:8.2-fpm

LABEL maintainer="Tiknil <info@tiknil.com>"

RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    curl \
    libmemcached-dev \
    libzip-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    git \
    cron \
    zip \
    unzip \
  && rm -rf /var/lib/apt/lists/*

##################
# PHP extensions #
##################

# RUN docker-php-ext-install mcrypt

RUN docker-php-ext-install pdo_mysql

RUN docker-php-ext-install exif

RUN docker-php-ext-install zip

RUN docker-php-ext-configure gd \
    --with-jpeg \
    --with-webp \
    --with-freetype=/usr/include/freetype2 && \
    docker-php-ext-install gd

# PCNTL extension (needed by horizon)
RUN docker-php-ext-install pcntl \
    && docker-php-ext-enable pcntl

#############
# PHP Redis #
#############

RUN pecl install -o -f redis \
  &&  rm -rf /tmp/pear \
  &&  docker-php-ext-enable redis

#############
# Composer  #
#############

ENV COMPOSER_MEMORY_LIMIT=-1

RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

####################
# Laravel Schedule #
####################

RUN echo "* * * * * root /usr/local/bin/php /var/www/artisan schedule:run >> /dev/null 2>&1"  >> /etc/cron.d/laravel-scheduler
RUN chmod 0644 /etc/cron.d/laravel-scheduler

# PHPunit alias
RUN echo "alias phpunit='php /var/www/vendor/bin/phpunit'" >> ~/.bashrc

# Custom ini config
ADD ./conf.ini /usr/local/etc/php/conf.d

RUN usermod -u 1000 www-data

WORKDIR /var/www

EXPOSE 9000
CMD ["php-fpm"]
