# Use the official PHP image with Apache web server pre-installed
FROM php:8.4-apache

# Copy all your project files into the web server directory
COPY . /var/www/html/

# Expose port 80 to allow web traffic
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
