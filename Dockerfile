FROM php:8.2-apache

# Install PDO MySQL and MySQLi extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files to the Apache document root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Ensure the web server (www-data) can write to the uploads folder
RUN mkdir -p /var/www/html/public/uploads && chown -R www-data:www-data /var/www/html/public/uploads

# Expose port 80
EXPOSE 80

# Configure Apache to listen on the port specified by the PORT env variable at runtime
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g' /etc/apache2/sites-available/000-default.conf

# Default PORT env variable to 80 (standard Apache port)
ENV PORT=80
