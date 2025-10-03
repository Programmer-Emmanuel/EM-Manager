# Utiliser l'image officielle PHP 8.2
FROM php:8.2-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    libicu-dev zlib1g-dev libssl-dev libzip-dev \
    libpq-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configurer et installer les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    bcmath \
    zip \
    opcache \
    pcntl \
    gd \
    intl

# Installer Redis via PECL
RUN pecl install redis && docker-php-ext-enable redis

# Installer Node.js LTS 20.x
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers composer
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copier le reste du code
COPY . .

# Permissions pour Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 storage bootstrap/cache

# Installer et builder les assets Node.js
RUN npm install && npm run build

# Exposer le port
EXPOSE 8000

# Commande de démarrage
CMD ["sh", "-c", "php artisan config:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]
