# Dockerfile — Symfony 7/8 + PHP 8.3 + Alpine + MySQL
FROM php:8.3-fpm-alpine AS base

# Installer dépendances système minimales
RUN apk add --no-cache \
    bash \
    git \
    zip \
    unzip \
    curl \
    libzip-dev \
    oniguruma-dev \
    libxml2-dev \
    icu-dev \
    && docker-php-ext-install pdo_mysql zip intl opcache

# Activer les extensions PHP utiles pour Symfony
RUN docker-php-ext-enable opcache

# Installer Composer (depuis image officielle)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www

# Copier uniquement les fichiers nécessaires pour installer les dépendances
COPY composer.json composer.lock ./

# Installer les dépendances PHP (sans dev pour prod)
RUN composer install --no-interaction --no-ansi --no-scripts --no-progress --prefer-dist --optimize-autoloader

# Copier le reste du projet
COPY . .

# Ajuster les permissions
RUN chown -R www-data:www-data var

# Configurer PHP-FPM pour écouter sur TCP (port 9000)
RUN sed -i 's|listen = .*|listen = 9000|' /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000

# Activer opcache pour la prod
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_OPCACHE_MEMORY_CONSUMPTION=256
ENV PHP_OPCACHE_MAX_ACCELERATED_FILES=20000

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
