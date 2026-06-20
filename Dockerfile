FROM php:8.4-apache

# install system dependencies + zip
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# enable apache rewrite
RUN a2enmod rewrite

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# copy project
COPY . /var/www/html

WORKDIR /var/www/html

# install dependencies
RUN composer install --no-dev --optimize-autoloader