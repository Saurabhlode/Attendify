FROM php:8.4-cli

# Install system dependencies & PHP extensions for Laravel
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libonig-dev libpng-dev libicu-dev \
    libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip intl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --no-progress --no-scripts

# Copy package files for npm caching
COPY package*.json ./
RUN npm ci --only=production

# Copy source code
COPY . /app

# Run composer scripts and build assets
RUN composer run-script post-autoload-dump && npm run build

# Optimize Laravel for production
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# Create required directories and set permissions
RUN mkdir -p /app/storage/logs /app/storage/framework/cache /app/storage/framework/sessions /app/storage/framework/views /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

# Configure OPcache for better performance
RUN echo 'opcache.enable=1' >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo 'opcache.memory_consumption=256' >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo 'opcache.max_accelerated_files=20000' >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo 'opcache.validate_timestamps=0' >> /usr/local/etc/php/conf.d/opcache.ini

# Expose port (Render uses PORT env var)
EXPOSE 8080

# Start command with optimizations
CMD ["/bin/sh", "-c", "php artisan migrate --force && (php artisan tinker --execute='echo App\\Models\\User::count();' | grep -q '^0$' && php artisan db:seed --force || echo 'Data exists, skipping seed') && php -d memory_limit=512M artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]