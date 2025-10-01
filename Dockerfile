# Image PHP avec extensions
FROM php:8.2-cli

# Installer dépendances système + extensions SQLite
RUN apt-get update && apt-get install -y \
    git curl unzip sqlite3 libsqlite3-dev zip \
    && docker-php-ext-install pdo pdo_sqlite

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Installer Node.js (pour Vite/Laravel Mix si besoin)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Définir le répertoire de travail
WORKDIR /var/www

# Copier tout le projet
COPY . .

# Installer dépendances PHP et JS
RUN composer install && \
    npm install && npm run build

# Donner les droits à storage et bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Exposer port 8000
EXPOSE 8000

# Commande de démarrage : serveur Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
