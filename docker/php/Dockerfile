FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip curl libzip-dev libpng-dev libjpeg-dev libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# définition du dossier de travail
WORKDIR /var/www/html

# copie de l'app dans le contenaire
COPY . .

# Install Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# fix certaines erreurs de permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
