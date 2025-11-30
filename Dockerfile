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
RUN --mount=type=cache,target=/root/.composer/cache \
    composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --no-progress --no-scripts

# Copy package files for npm caching
COPY package*.json ./
RUN --mount=type=cache,target=/root/.npm \
    npm ci

# Copy source code
COPY . /app

# Run composer scripts and build assets
RUN composer run-script post-autoload-dump && npm run build && npm prune --production

# Laravel optimization will be done at runtime in start.sh
# This allows proper environment variable injection

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

# Copy and make startup script executable
COPY start.sh /app/start.sh
RUN chmod +x /app/start.sh

# Use startup script
CMD ["/app/start.sh"]