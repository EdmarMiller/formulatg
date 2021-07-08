FROM php:8.0.7-fpm

ARG user
ARG uid

# Install dependencies
RUN apt-get update && apt-get install -y \
   libonig-dev \
   libmcrypt-dev \
   zlib1g-dev \
   libpng-dev \
   libxml2-dev \
   nano \
   zip \
   git

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install \
    bcmath \
    dom \
    intl \
    mbstring \
    mysqli \
    opcache \
    pdo \
    pdo_mysql

RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

# Install xdebug
RUN pecl install xdebug-3.0.1 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
#PHPUNIT
RUN composer global require "phpunit/phpunit"
ENV PATH /root/.composer/vendor/bin:$PATH
RUN ln -s /root/.composer/vendor/bin/phpunit /usr/bin/phpunit

USER $user
