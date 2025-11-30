FROM php:8.4-cli

# Install system dependencies & PHP extensions for Laravel
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libonig-dev libpng-dev libicu-dev \
    libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy files
COPY . /app

# Install dependencies and build assets
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --no-progress
RUN npm install && npm run build

# Create minimal .env for Laravel
RUN echo "APP_ENV=production" > .env && \
    echo "DB_CONNECTION=pgsql" >> .env && \
    echo "APP_KEY=base64:ixs+AuINQiv7+pVevysg5yMaxXZ2H0kE6XXyaSfeG60=" >> .env

# Create required directories and set permissions
RUN mkdir -p /app/storage/logs /app/storage/framework/cache /app/storage/framework/sessions /app/storage/framework/views /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

# Expose port (Render uses PORT env var)
EXPOSE 8080

# Start command with environment debug
CMD ["/bin/sh", "-c", "echo 'DB_HOST='$DB_HOST && php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]