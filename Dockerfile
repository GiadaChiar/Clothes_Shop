FROM php:8.4-apache

# installa estensioni PHP necessarie
RUN docker-php-ext-install pdo pdo_mysql

# abilita rewrite (utile per router)
RUN a2enmod rewrite

# copia codice
COPY . /var/www/html

# installa composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# installa dipendenze PHP
RUN composer install --no-dev --optimize-autoloader

# set working dir
WORKDIR /var/www/html