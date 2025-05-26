# Use PHP 8.1 with Apache
FROM php:8.1-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies and build assets
RUN npm install && npm run build

# Cache Laravel configurations
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port
EXPOSE 8080

# Start command
CMD php artisan migrate --force && \
    php artisan storage:link && \
    php -S 0.0.0.0:$PORT -t public 