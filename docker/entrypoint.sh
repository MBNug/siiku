#!/bin/sh
set -e

PORT="${PORT:-8080}"

# Bind Apache to Render's dynamic $PORT
sed -ri "s/Listen [0-9]+/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Ensure Laravel writable directories exist
mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    storage/app/public \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

# Ensure public storage symlink exists
rm -rf public/storage
php artisan storage:link || true

# Clear cached config/routes/views so runtime env vars are respected
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations if enabled (default: true)
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    php artisan migrate --force
fi

# Seed once on empty database when RUN_SEED=true
if [ "${RUN_SEED:-false}" = "true" ]; then
    HAS_USERS=$(php -r "
        require 'vendor/autoload.php';
        \$app = require 'bootstrap/app.php';
        \$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
        \$kernel->bootstrap();
        echo \App\Models\User::query()->exists() ? '1' : '0';
    " 2>/dev/null || echo "0")

    if [ "$HAS_USERS" = "0" ]; then
        php artisan db:seed --force
    fi
fi

exec apache2-foreground
