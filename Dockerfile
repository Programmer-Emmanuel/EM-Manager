FROM php:8.2-cli

# Installer dépendances système + extensions PHP (dont GD, mbstring, exif, bcmath utiles pour Laravel)
RUN apt-get update && apt-get install -y \
    git curl unzip sqlite3 libsqlite3-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_sqlite gd mbstring exif bcmath

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Autoriser composer à tourner en root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

WORKDIR /var/www

# Copier uniquement fichiers Composer d’abord (pour cache Docker)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copier tout le projet
COPY . .

# Installer dépendances JS (vite, etc.)
RUN npm install && npm run build

# Donner droits
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
