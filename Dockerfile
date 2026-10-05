# Use the official PHP image with Apache web server pre-installed
FROM php:8.4-apache

# The website talks to MySQL, so PHP needs the MySQL drivers (not included in the base image)
RUN docker-php-ext-install pdo_mysql mysqli

# Allow photo uploads from the admin panel (PHP's default is only 2 MB)
RUN { echo 'upload_max_filesize=16M'; echo 'post_max_size=20M'; } > /usr/local/etc/php/conf.d/uploads.ini

# Copy all your project files into the web server directory
COPY . /var/www/html/

# Folder where the admin panel stores uploaded photos
RUN mkdir -p /var/www/html/images/uploads && chown -R www-data:www-data /var/www/html/images/uploads

# Expose port 80 to allow web traffic
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
