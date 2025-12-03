FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip curl \
    && docker-php-ext-install pdo_mysql zip gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/sahabat_group

# Copy Laravel app
COPY . /var/www/sahabat_group

# Copy Composer dari official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Buat storage link
RUN php artisan storage:link

# Set permission
RUN chown -R www-data:www-data storage bootstrap/cache public \
    && chmod -R 755 storage bootstrap/cache public

# ✅ Set Apache DocumentRoot ke `public` folder dalam Laravel
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/sahabat_group/public|' /etc/apache2/sites-available/000-default.conf

# ✅ AllowOverride All untuk .htaccess agar routing Laravel bisa jalan
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# ✅ Expose port 80 (bukan 8000, karena Apache listen di 80)
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
