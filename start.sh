#!/bin/bash

# Create .env file with environment variables
cat > .env << EOF
APP_NAME=\${APP_NAME:-Attendify}
APP_ENV=\${APP_ENV:-production}
APP_DEBUG=\${APP_DEBUG:-false}
APP_KEY=\${APP_KEY}
APP_URL=\${APP_URL}

DB_CONNECTION=\${DB_CONNECTION:-pgsql}
DB_HOST=\${DB_HOST}
DB_PORT=\${DB_PORT:-5432}
DB_DATABASE=\${DB_DATABASE}
DB_USERNAME=\${DB_USERNAME}
DB_PASSWORD=\${DB_PASSWORD}

SESSION_DRIVER=\${SESSION_DRIVER:-database}
CACHE_STORE=\${CACHE_STORE:-database}
QUEUE_CONNECTION=\${QUEUE_CONNECTION:-database}

MAIL_MAILER=\${MAIL_MAILER:-smtp}
MAIL_HOST=\${MAIL_HOST}
MAIL_PORT=\${MAIL_PORT:-587}
MAIL_USERNAME=\${MAIL_USERNAME}
MAIL_PASSWORD=\${MAIL_PASSWORD}
MAIL_ENCRYPTION=\${MAIL_ENCRYPTION:-tls}
MAIL_FROM_ADDRESS=\${MAIL_FROM_ADDRESS}
MAIL_FROM_NAME=\${MAIL_FROM_NAME:-Attendify}

LOG_CHANNEL=stack
LOG_LEVEL=\${LOG_LEVEL:-error}
EOF

# Production startup
echo "Starting Attendify in production mode..."
echo "PHP Version: $(php -v | head -n 1)"

# Clear any cached config first
php artisan config:clear
php artisan cache:clear

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed demo users for production
echo "Creating demo users..."
php artisan db:seed --class=ProductionSeeder --force

# Optimize for production
echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start server
echo "Starting server on port ${PORT:-8080}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}