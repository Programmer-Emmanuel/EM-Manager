FROM php:8.2-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer dépendances système pour PHP + GD + PECL
RUN apt-get update && apt-get install -y \
    git curl unzip sqlite3 libsqlite3-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libicu-dev zlib1g-dev g++ pkg-config \
    php8.2-dev libssl-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Node.js LTS 20.x via NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configurer et installer extensions PHP
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_sqlite gd mbstring exif bcmath zip intl opcache pcntl

# Installer Redis via PECL
RUN pecl install redis \
    && docker-php-ext-enable redis

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tout le projet (artisan doit exister avant composer install)
COPY . .

# Installer dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installer dépendances JS et builder Vite
RUN npm install && npm run build

# Droits sur storage et bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
