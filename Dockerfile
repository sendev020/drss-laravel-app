# Utilise une image officielle PHP avec extensions nécessaires
FROM php:8.2-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer le dossier de l'app
WORKDIR /var/www

# Copier le contenu de l'application dans le conteneur
COPY . .

# Copie un fichier .env.example en .env SI tu ne le fournis pas déjà dans ton projet
RUN cp .env.example .env

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Générer la clé Laravel
RUN php artisan key:generate

# Créer le lien symbolique vers storage
RUN php artisan storage:link

# Exposer le port (utile pour render/startCommand)
EXPOSE 8000

# Lancer Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

