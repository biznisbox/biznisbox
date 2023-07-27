#!/bin/bash

echo "Setting up permissions..."
chgrp -R www-data storage bootstrap/cache && \
chown -R www-data storage bootstrap/cache && \
chmod -R ug+rwx storage bootstrap/cache && \
chmod 776 storage/ -R

echo "Setting up project..."

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

echo "Generating key..."
php artisan key:generate
echo "Deploying..."
php deploy

echo "Migrating..."
php artisan migrate

crontab -u www-data /var/www/html/docker/cron
echo "Permission setup Done... Project now ready to serve"
exec "$@"