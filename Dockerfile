FROM php:8.2-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

# Mettre à jour la liste des paquets et installer les dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip sqlite3 \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    libicu-dev zlib1g-dev libssl-dev libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configurer et installer les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
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

# Installer Node.js LTS 20.x via NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de configuration pour mieux utiliser le cache Docker
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copier le reste des fichiers
COPY . .

# Définir les permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 storage bootstrap/cache

# Installer et builder les assets Node.js
RUN npm install && npm run build

# Exposer le port
EXPOSE 8000

# Commande pour démarrer le serveur

CMD ["sh", "-c", "php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000"]