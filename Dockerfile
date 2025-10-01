# Stage 1 : Développement Laravel + Node
FROM php:8.2-cli

# Installer dépendances système + extensions PHP
RUN apt-get update && apt-get install -y \
    git curl unzip sqlite3 libsqlite3-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libicu-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_sqlite gd mbstring exif bcmath zip intl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Autoriser composer à tourner en root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer Node.js (LTS 20.x)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && apt-get clean && rm -rf /var/lib/apt/lists/*

# Définir le répertoire de travail
WORKDIR /var/www

# Copier fichiers Composer d'abord pour tirer parti du cache Docker
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copier package.json et package-lock.json pour installer les dépendances JS
COPY package*.json ./
RUN npm install && npm run build

# Copier tout le reste du projet
COPY . .

# Donner droits sur storage et bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Exposer port Laravel (php artisan serve)
EXPOSE 8000

# Commande de démarrage (dev)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
