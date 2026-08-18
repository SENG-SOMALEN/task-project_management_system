FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project
COPY . .

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist
    --ignore-platform-reqs

# Set Laravel permissions
RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Configure Apache for Laravel
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' \
    /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<VirtualHost \*:80>/a \
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>' \
    /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]