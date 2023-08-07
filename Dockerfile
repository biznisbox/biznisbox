FROM ubuntu:latest
ARG DEBIAN_FRONTEND=noninteractive

LABEL maintainer="BiznisBox <app@biznisbox.com>"
LABEL version="1.0"
LABEL description="Docker image for BiznisBox application"
LABEL github="https://github.com/biznisbox/biznisbox"

# Update and upgrade packages
RUN apt-get update && apt-get upgrade -y

# Install basic packages
RUN apt-get install -y curl git unzip wget zip openssl cron nano vim libxml2-dev libzip-dev curl libmcrypt-dev libpng-dev libonig-dev sendmail-bin sendmail 

# Install PHP
RUN apt-get install -y php php-cli php-fpm php-json php-pdo php-mysql php-zip php-gd php-mbstring php-curl php-xml php-pear php-bcmath php-ldap php-opcache php-intl php-sqlite3

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install Nginx
RUN apt-get install -y nginx

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs
RUN npm install -g npm@latest

# Copy Nginx config
COPY ./docker/nginx/default.conf /etc/nginx/sites-available/default

# Copy PHP config
COPY ./docker/php/laravel.ini /etc/php/8.1/fpm/laravel.ini

# Copy App
COPY . /var/www/html

# Set permission for Nginx
RUN chown -R www-data:www-data /var/www/html

# Set working directory
WORKDIR /var/www/html

# Create volume
VOLUME [ "/var/www/html/storage" ]

# Install dependencies
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader
RUN npm install 

# Copy .env
COPY .env.example .env

# Deploy frontend
RUN npm run build 
RUN php deploy
RUN npm install --omit=dev

# Generate key
RUN php artisan key:generate

# Set permission
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/bootstrap/cache

# Set Laravel cron
RUN echo "* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontab

# Expose port 80
EXPOSE 80

# Start Nginx and PHP-FPM and start cron 
CMD service php8.1-fpm start && nginx -g "daemon off;"
