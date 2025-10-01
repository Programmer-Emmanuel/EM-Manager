# Image PHP avec extensions nécessaires pour Laravel
FROM php:8.2-cli

# Autoriser composer à tourner en root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer dépendances système + extensions PHP
RUN apt-get update && apt-get install -y \
    git curl unzip sqlite3 libsqlite3-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libicu-dev zlib1g-dev g++ pkg-config \
    npm nodejs \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_sqlite gd mbstring exif bcmath zip intl opcache pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tout le projet d'abord (artisan doit exister avant composer install)
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installer les dépendances JS et builder Vite
RUN npm install && npm run build

# Droits sur storage et bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Exposer le port Laravel (php artisan serve)
EXPOSE 8000

# Commande par défaut pour dev
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
