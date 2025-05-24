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
    sed -i "s|^CACHE_DRIVER=.*|CACHE_DRIVER=${CACHE_DRIVER:-file}|g" "$ENV_FILE"

    # Email configuration
    sed -i "s|^MAIL_MAILER=.*|MAIL_MAILER=${MAIL_MAILER:-log}|g" "$ENV_FILE"
    sed -i "s|^MAIL_HOST=.*|MAIL_HOST=${MAIL_HOST:-mail}|g" "$ENV_FILE"
    sed -i "s|^MAIL_PORT=.*|MAIL_PORT=${MAIL_PORT:-587}|g" "$ENV_FILE"
    sed -i "s|^MAIL_USERNAME=.*|MAIL_USERNAME=${MAIL_USERNAME:-null}|g" "$ENV_FILE"
    sed -i "s|^MAIL_PASSWORD=.*|MAIL_PASSWORD=${MAIL_PASSWORD:-null}|g" "$ENV_FILE"
    sed -i "s|^MAIL_ENCRYPTION=.*|MAIL_ENCRYPTION=${MAIL_ENCRYPTION:-tls}|g" "$ENV_FILE"
    sed -i "s|^MAIL_FROM_ADDRESS=.*|MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS:-null}|g" "$ENV_FILE"
    sed -i "s|^MAIL_FROM_NAME=.*|MAIL_FROM_NAME=${MAIL_FROM_NAME:-BiznisBox}|g" "$ENV_FILE"

    # App demo mode
    sed -i "s|^APP_DEMO_MODE=.*|APP_DEMO_MODE=${APP_DEMO_MODE:-false}|g" "$ENV_FILE"

    echo ".env file generated."
else
    echo ".env file already exists, skipping generation."
fi

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

if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running database migrations (RUN_MIGRATIONS=true)..."
    if [ "$(whoami)" = 'root' ]; then
        su-exec www-data php artisan migrate --force --no-interaction
    else
        php artisan migrate --force --no-interaction
    fi
    echo "Migrations complete."
else
    echo "Skipping migrations (RUN_MIGRATIONS is not 'true')."
fi

if [ "${OPTIMIZE_APP}" = "true" ]; then
    echo "Optimizing application (OPTIMIZE_APP=true)..."
     if [ "$(whoami)" = 'root' ]; then
        su-exec www-data php artisan config:cache
        su-exec www-data php artisan route:cache
     else
        php artisan config:cache
        php artisan route:cache
     fi
    echo "Optimization complete."
else
    echo "Skipping optimization (OPTIMIZE_APP is not 'true')."
fi

if [ "$(whoami)" = 'root' ]; then
    chown www-data:www-data "$ENV_FILE"
    chmod 644 "$ENV_FILE"
else
    echo "Warning: entrypoint.sh not running as root, cannot guarantee correct permissions for .env file."
fi

echo "Container setup complete. Executing command: $@"
exec "$@"