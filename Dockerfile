# Use the official PHP image
FROM php:8.2-fpm

# Set the working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the Laravel application files
COPY . .

# Install PHP dependencies
RUN composer install

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start the PHP-FPM server
CMD ["php-fpm"]
