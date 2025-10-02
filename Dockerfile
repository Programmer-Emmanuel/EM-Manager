FROM php:8.2-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

# Mettre à jour la liste des paquets et installer les dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip sqlite3 libsqlite3-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    icu-devtools libicu-dev zlib1g-dev libssl-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Node.js LTS 20.x via NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer les extensions de base d'abord
RUN docker-php-ext-install pdo pdo_sqlite mbstring exif bcmath zip opcache pcntl

# Installer intl avec ses dépendances spécifiques
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# Installer GD
RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install gd

# Installer Redis via PECL
RUN pecl install redis && docker-php-ext-enable redis

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier d'abord les fichiers de configuration pour mieux utiliser le cache Docker
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