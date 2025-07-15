# Étape 1 : Image de base PHP avec extensions nécessaires
FROM php:8.2-fpm

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
    libmcrypt-dev \
    vim \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier tous les fichiers de l'application
COPY . .

# Installer les dépendances PHP de Laravel
RUN composer install --no-dev --optimize-autoloader

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN cp .env.example .env || touch .env

# Générer la clé d'application Laravel
RUN php artisan key:generate

# Créer le lien symbolique vers public/storage
RUN php artisan storage:link || true

# Lancer les migrations en mode production
RUN php artisan migrate --force || true

# Exposer le port 8000
EXPOSE 8000

# Commande de démarrage
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
