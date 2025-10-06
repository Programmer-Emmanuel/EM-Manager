# PHP CLI avec extensions nécessaires
FROM php:8.3-cli

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip curl vim libonig-dev npm nodejs \
    && docker-php-ext-install pdo_pgsql mbstring zip bcmath pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer (version stable) directement
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir répertoire de travail
WORKDIR /var/www/html

# Copier le projet
COPY . /var/www/html

# Installer dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Exposer le port
EXPOSE 8000

# Lancer serveur PHP
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
