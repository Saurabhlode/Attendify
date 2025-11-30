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

# Check current user count
echo "Checking current users..."
php artisan tinker --execute="echo 'User count: ' . App\Models\User::count();" || echo "User count check failed"

# Seed demo users for production
echo "Creating demo users..."
php artisan db:seed --class=ProductionSeeder --force || {
    echo "ProductionSeeder failed, trying ForceUserSeeder..."
    php artisan db:seed --class=ForceUserSeeder --force || echo "All seeding failed"
}

# Verify users were created
echo "Verifying demo users..."
php artisan tinker --execute="echo 'Final user count: ' . App\Models\User::count(); echo 'Admin exists: ' . (App\Models\User::where('email', 'admin@attendify.com')->exists() ? 'YES' : 'NO');" || echo "User verification failed"

# Optimize for production
echo "Optimizing for production..."
php artisan config:cache || echo "Config cache failed"
php artisan route:cache || echo "Route cache failed"
php artisan view:cache || echo "View cache failed"

# Start server
echo "Starting server on port ${PORT:-8080}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}