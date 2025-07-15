# Étape 1 : Image de base PHP avec extensions nécessaires
FROM php:8.2-cli

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    vim \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring exif pcntl bcmath gd

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Copier .env si inexistant
RUN cp .env.example .env || true

# Donner les permissions nécessaires
RUN chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

# Générer la clé d’application
RUN php artisan key:generate || true

# Lier le dossier public/storage
RUN php artisan storage:link || true

# Appliquer les migrations
RUN php artisan migrate --force || true
RUN php artisan db:seed --force || true

# Exposer le port que Render va détecter
EXPOSE 10000

# Lier le stockage Render à Laravel
RUN rm -rf storage/app/public && ln -s /var/storage storage/app/public

# Lancer le serveur Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
