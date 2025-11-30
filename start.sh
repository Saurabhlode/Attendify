#!/bin/bash

# Create .env file with required variables
cat > .env << EOF
APP_NAME=Attendify
APP_ENV=production
APP_DEBUG=true
APP_KEY=base64:ixs+AuINQiv7+pVevysg5yMaxXZ2H0kE6XXyaSfeG60=
APP_URL=https://attendify-2-krca.onrender.com

DB_CONNECTION=pgsql
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stack
LOG_LEVEL=debug
MAIL_MAILER=log
EOF

# Debug startup
echo "Starting Attendify..."
echo "PHP Version: $(php -v | head -n 1)"
echo "Laravel Version: $(php artisan --version)"

# Clear any cached config
php artisan config:clear

# Test database connection
echo "Testing database connection..."
php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Database connected successfully'; } catch(Exception \$e) { echo 'Database error: ' . \$e->getMessage(); }"

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database if empty
echo "Seeding database..."
php artisan db:seed --force || true

# Start server
echo "Starting server on port ${PORT:-8080}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}