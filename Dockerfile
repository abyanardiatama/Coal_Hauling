# Gunakan image resmi PHP dengan ekstensi yang diperlukan
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy aplikasi Laravel ke container
COPY . .

# Berikan izin ke storage dan bootstrap cache
RUN chmod -R 777 storage bootstrap/cache

# Expose port
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]
