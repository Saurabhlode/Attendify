#!/bin/bash

# Create .env file with minimal required variables
cat > .env << EOF
APP_NAME=Attendify
APP_ENV=production
APP_DEBUG=false
APP_KEY=${APP_KEY}
APP_URL=${APP_URL}

DB_CONNECTION=pgsql
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=log
EOF

# Production startup
echo "Starting Attendify in production mode..."
echo "PHP Version: $(php -v | head -n 1)"
echo "Environment: $(cat .env | head -5)"

# Clear any cached config first
echo "Clearing caches..."
php artisan config:clear || echo "Config clear failed"
php artisan cache:clear || echo "Cache clear failed"

# Test database connection
echo "Testing database connection..."
php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Database connected successfully'; } catch(Exception \$e) { echo 'Database error: ' . \$e->getMessage(); }" || echo "Database test failed"

# Run migrations
echo "Running database migrations..."
php artisan migrate --force || echo "Migration failed"

# Seed demo users for production
echo "Creating demo users..."
php artisan db:seed --class=ProductionSeeder --force || echo "Seeding failed"

# Optimize for production
echo "Optimizing for production..."
php artisan config:cache || echo "Config cache failed"
php artisan route:cache || echo "Route cache failed"
php artisan view:cache || echo "View cache failed"

# Start server
echo "Starting server on port ${PORT:-8080}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}