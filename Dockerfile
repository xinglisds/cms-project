# Use PHP 8.2 with CLI (matching composer.json requirement)
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Set Composer environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

# Install PHP dependencies with verbose output for debugging
RUN composer install --no-dev --optimize-autoloader --no-scripts --verbose

# Copy package.json files
COPY package*.json ./

# Install Node.js dependencies (including devDependencies for build)
RUN npm ci

# Copy the rest of the application
COPY . .

# Set environment for build
ENV NODE_ENV=production
ENV APP_ENV=production

# Build frontend assets
RUN npm run build

# Remove node_modules to save space (optional)
RUN rm -rf node_modules

# Set proper permissions
RUN chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Expose port
EXPOSE 8080

# Start command
CMD php artisan migrate --force && \
    php artisan storage:link && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php -S 0.0.0.0:$PORT -t public 