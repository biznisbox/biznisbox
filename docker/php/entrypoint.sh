#!/bin/sh
set -e

ENV_FILE="/var/www/html/.env"
ENV_EXAMPLE_FILE="/var/www/html/.env.example"

if [ ! -f "$ENV_EXAMPLE_FILE" ]; then
    echo "Error: .env.example not found at $ENV_EXAMPLE_FILE inside the image!"
fi

if [ ! -f "$ENV_FILE" ]; then
    echo "Generating $ENV_FILE from environment variables..."

    cp "$ENV_EXAMPLE_FILE" "$ENV_FILE"

    # Basic environment variable substitution
    sed -i "s|^APP_NAME=.*|APP_NAME=${APP_NAME:-BiznisBox}|g" "$ENV_FILE"
    sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV:-production}|g" "$ENV_FILE"
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG:-false}|g" "$ENV_FILE" 
    sed -i "s|^APP_URL=.*|APP_URL=${APP_URL:-http://localhost}|g" "$ENV_FILE"

    # APP_KEY
    if [ -n "${APP_KEY}" ]; then
        escaped_app_key=$(printf '%s\n' "${APP_KEY}" | sed -e 's/[\/&]/\\&/g')
        sed -i "s|^APP_KEY=.*|APP_KEY=${escaped_app_key}|g" "$ENV_FILE"
    fi

    # Database configuration
    sed -i "s|^APP_TIMEZONE=.*|APP_TIMEZONE=${APP_TIMEZONE:-UTC}|g" "$ENV_FILE"
    sed -i "s|^DB_URL=.*|DB_URL=${DB_URL:-null}|g" "$ENV_FILE"
    sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION:-mysql}|g" "$ENV_FILE"
    sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST:-db}|g" "$ENV_FILE"
    sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT:-3306}|g" "$ENV_FILE"
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE:-biznisbox}|g" "$ENV_FILE"
    sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME:-biznisbox_user}|g" "$ENV_FILE"
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD:-password}|g" "$ENV_FILE"

    # Email configuration
    sed -i "s|^MAIL_MAILER=.*|MAIL_MAILER=${MAIL_MAILER:-log}|g" "$ENV_FILE"
    sed -i "s|^MAIL_HOST=.*|MAIL_HOST=${MAIL_HOST:-mail}|g" "$ENV_FILE"
    sed -i "s|^MAIL_PORT=.*|MAIL_PORT=${MAIL_PORT:-587}|g" "$ENV_FILE"
    sed -i "s|^MAIL_USERNAME=.*|MAIL_USERNAME=${MAIL_USERNAME:-null}|g" "$ENV_FILE"
    sed -i "s|^MAIL_PASSWORD=.*|MAIL_PASSWORD=${MAIL_PASSWORD:-null}|g" "$ENV_FILE"
    sed -i "s|^MAIL_ENCRYPTION=.*|MAIL_ENCRYPTION=${MAIL_ENCRYPTION:-tls}|g" "$ENV_FILE"
    sed -i "s|^MAIL_FROM_ADDRESS=.*|MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS:-demo@example.com}|g" "$ENV_FILE"
    sed -i "s|^MAIL_FROM_NAME=.*|MAIL_FROM_NAME=${MAIL_FROM_NAME:-BiznisBox}|g" "$ENV_FILE"

    # App demo mode
    sed -i "s|^APP_DEMO_MODE=.*|APP_DEMO_MODE=${APP_DEMO_MODE:-false}|g" "$ENV_FILE"
    sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=${QUEUE_CONNECTION:-database}|g" "$ENV_FILE"

    if [ "${APP_DEMO_MODE}" = "true" ]; then
        sed -i "s|^MAIL_MAILER=.*|MAIL_MAILER=log|g" "$ENV_FILE"
    fi

    sed -i "s|^APP_MODE=.*|APP_MODE=${APP_MODE:-production}|g" "$ENV_FILE"

    echo ".env file generated."
else
    echo ".env file already exists, skipping generation."
fi

# Set ownership and permissions
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
# Ensure the .env file is readable by www-data
chmod 644 "$ENV_FILE"

# Storage directory setup link php artisan storage:link
if [ -d /var/www/html/storage ]; then
    echo "Setting up storage directory..."
    if [ "$(whoami)" = 'root' ]; then
        su-exec www-data php artisan storage:link --force --no-interaction
    else
        php artisan storage:link --force --no-interaction
    fi
    echo "Storage directory setup complete."
else
    echo "Storage directory does not exist, skipping setup."
fi

# Generate APP_KEY if not set
current_app_key=$(grep '^APP_KEY=' "$ENV_FILE" | cut -d '=' -f2-)
if [ -z "${current_app_key}" ]; then
    echo "APP_KEY is empty in .env, generating new key..."
    # Run artisan commands as www-data user if the script is run as root
    if [ "$(whoami)" = 'root' ]; then
        su-exec www-data php artisan key:generate --force --no-interaction
    else
        php artisan key:generate --force --no-interaction
    fi
    echo "APP_KEY generated."
fi

# If APP_MODE is set to 'demo' or 'development', install composer to image 
if [ "${APP_MODE}" = "demo" ] || [ "${APP_MODE}" = "development" ]; then
    echo "Installing Composer for demo/development mode..."
    if [ ! -f /usr/local/bin/composer ]; then
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
        php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
        php composer-setup.php --install-dir=/usr/local/bin --filename=composer
        rm composer-setup.php
    fi
    echo "Composer installed."
else
    echo "Skipping Composer installation (APP_MODE is not 'demo' or 'development')."
fi

echo "Container setup complete. Executing command: $@"
exec "$@"