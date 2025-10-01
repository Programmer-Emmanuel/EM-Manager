FROM php:8.2-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer les dépendances système en une seule étape
RUN apt-get update && apt-get install -y \
    git curl unzip sqlite3 libsqlite3-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    libicu-dev zlib1g-dev g++ pkg-config libssl-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Node.js (version plus efficace)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Configurer et installer les extensions PHP
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_sqlite gd mbstring exif bcmath zip intl opcache pcntl

# Installer Redis
RUN pecl install redis && docker-php-ext-enable redis

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier d'abord les fichiers de configuration pour un meilleur cache Docker
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copier le reste des fichiers
COPY . .

# Installer et builder les assets
RUN npm install && npm run build

# Définir les permissions
RUN chmod -R 755 storage bootstrap/cache

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]