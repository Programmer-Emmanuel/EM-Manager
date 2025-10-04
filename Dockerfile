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

# Installer extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif bcmath zip opcache pcntl gd intl
RUN pecl install redis && docker-php-ext-enable redis

# Installer Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier tout d'un coup
COPY . .

# FORCER l'environnement PostgreSQL
ENV DB_CONNECTION=pgsql
ENV DB_HOST=dpg-d3g104u3jp1c73fj5ja0-a.oregon-postgres.render.com
ENV DB_PORT=5432
ENV DB_DATABASE=em_manager
ENV DB_USERNAME=em_manager_user
ENV DB_PASSWORD=ReDTdSna6mJVBi90I1GMiD0uLfsymTkN
ENV APP_ENV=production
ENV APP_DEBUG=false

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN npm install && npm run build

# Configurer l'application
RUN php artisan key:generate --force
RUN php artisan config:clear

# Permissions
RUN chmod -R 755 storage bootstrap/cache

EXPOSE 8000

# Démarrer simplement
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]