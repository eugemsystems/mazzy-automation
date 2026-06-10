# /srv/mazzy/laravel/Dockerfile
FROM php:8.4-fpm-alpine

# Install system dependencies + PHP extensions
RUN apk add --no-cache \
    git \
    curl \
    unzip \
    sqlite \
    sqlite-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_sqlite opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/laravel

# Copy app source (used during image build; runtime uses bind-mount)
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build assets (if using Vite)
RUN npm ci && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/laravel \
    && chmod -R 755 /var/www/laravel/storage \
    && chmod -R 755 /var/www/laravel/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
