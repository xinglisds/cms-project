#!/bin/bash

echo "🚀 Starting deployment process..."

# Clear caches
echo "📝 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Create storage link (if not exists)
echo "🔗 Creating storage link..."
php artisan storage:link

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

echo "✅ Deployment completed successfully!" 