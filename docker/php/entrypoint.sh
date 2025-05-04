#!/bin/sh
# Exit immediately if a command exits with a non-zero status.
set -e

# Define the target .env file path
ENV_FILE="/var/www/html/.env"
ENV_EXAMPLE_FILE="/var/www/html/.env.example" # Assuming .env.example is copied into image

# Check if .env.example exists
if [ ! -f "$ENV_EXAMPLE_FILE" ]; then
    echo "Error: .env.example not found at $ENV_EXAMPLE_FILE inside the image!"
    # Attempt to create a basic one if missing? Or just exit.
    # echo "Creating minimal .env.example..."
    # echo "APP_KEY=" > "$ENV_EXAMPLE_FILE"
    # echo "DB_HOST=db" >> "$ENV_EXAMPLE_FILE"
    # ... add other essential defaults
    # exit 1 # Exit if critical
fi

# Check if .env exists. If running the image multiple times with mounted volumes,
# it might exist. If not, generate from ENV VARS.
if [ ! -f "$ENV_FILE" ]; then
    echo "Generating $ENV_FILE from environment variables..."

    # Copy .env.example to .env to ensure all keys exist
    cp "$ENV_EXAMPLE_FILE" "$ENV_FILE"

    # Use sed to replace placeholders based on environment variables passed to 'docker run'
    # Make sure the variable names here match those expected by your app
    sed -i "s|^APP_NAME=.*|APP_NAME=${APP_NAME:-Laravel}|g" "$ENV_FILE"
    sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV:-production}|g" "$ENV_FILE" # Default to production
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG:-false}|g" "$ENV_FILE" # Default to false
    sed -i "s|^APP_URL=.*|APP_URL=${APP_URL:-http://localhost}|g" "$ENV_FILE"

    # Only set APP_KEY if the passed variable is not empty
    if [ -n "${APP_KEY}" ]; then
        escaped_app_key=$(printf '%s\n' "${APP_KEY}" | sed -e 's/[\/&]/\\&/g')
        sed -i "s|^APP_KEY=.*|APP_KEY=${escaped_app_key}|g" "$ENV_FILE"
    fi

    sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION:-mysql}|g" "$ENV_FILE"
    sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST:-db}|g" "$ENV_FILE"
    sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT:-3306}|g" "$ENV_FILE"
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE:-laravel}|g" "$ENV_FILE"
    sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME:-user}|g" "$ENV_FILE"
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD:-password}|g" "$ENV_FILE"

    sed -i "s|^REDIS_HOST=.*|REDIS_HOST=${REDIS_HOST:-redis}|g" "$ENV_FILE"
    sed -i "s|^REDIS_PASSWORD=.*|REDIS_PASSWORD=${REDIS_PASSWORD:-null}|g" "$ENV_FILE"
    sed -i "s|^REDIS_PORT=.*|REDIS_PORT=${REDIS_PORT:-6379}|g" "$ENV_FILE"

    sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=${QUEUE_CONNECTION:-redis}|g" "$ENV_FILE"

    # Add more sed commands here for other essential variables (MAIL, AWS, etc.)

    echo ".env file generated."
else
    echo ".env file already exists, skipping generation."
    # Optional: You could still update specific keys if needed, but be careful
    # sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST:-db}|g" "$ENV_FILE" # Example: always update DB host
fi

# Generate APP_KEY if it's missing or empty in the .env file
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

# Wait for DB? Only relevant if DB is external and might start slower.
# Add a check here if needed: while ! nc -z $DB_HOST $DB_PORT; do sleep 1; done;

# Run database migrations (only if enabled via an env var, perhaps?)
# Be cautious about running migrations automatically in a distributed image.
# It's often better done as a separate step during deployment.
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


# Run Optimizations (Config/Route cache) - Again, consider if this should be automatic.
# Caching routes/config based on env vars generated at runtime can be tricky.
# It might be better to do this in the Dockerfile build if the env is somewhat fixed,
# or manually after deployment.
if [ "${OPTIMIZE_APP}" = "true" ]; then
    echo "Optimizing application (OPTIMIZE_APP=true)..."
     if [ "$(whoami)" = 'root' ]; then
        su-exec www-data php artisan config:cache
        su-exec www-data php artisan route:cache
        # su-exec www-data php artisan view:cache # View cache less common to auto-run
     else
        php artisan config:cache
        php artisan route:cache
        # php artisan view:cache
     fi
    echo "Optimization complete."
else
    echo "Skipping optimization (OPTIMIZE_APP is not 'true')."
fi


# Set permissions for storage and cache. This is crucial as the container runs.
# This needs to run as root to potentially change ownership if volumes are mounted externally.
echo "Setting permissions for storage and bootstrap/cache..."
if [ "$(whoami)" = 'root' ]; then
    # Ensure directories exist (might not if volume is freshly mounted)
    mkdir -p /var/www/html/storage/framework/sessions
    mkdir -p /var/www/html/storage/framework/views
    mkdir -p /var/www/html/storage/framework/cache/data
    mkdir -p /var/www/html/storage/logs
    mkdir -p /var/www/html/bootstrap/cache

    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
    chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache
    echo "Permissions set."
else
    echo "Warning: entrypoint.sh not running as root, cannot guarantee correct permissions for storage/bootstrap/cache if volumes are mounted."
    # Attempt to set permissions anyway, might fail
    chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache || true
fi

# Env must be writable by the web server
if [ "$(whoami)" = 'root' ]; then
    chown www-data:www-data "$ENV_FILE"
    chmod 644 "$ENV_FILE"
else
    echo "Warning: entrypoint.sh not running as root, cannot guarantee correct permissions for .env file."
fi

# Execute the main command passed to the container (CMD in Dockerfile)
echo "Container setup complete. Executing command: $@"
exec "$@"