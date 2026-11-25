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

# Seed on empty DB, or auto-upgrade legacy <=5-indicator / uniform demo seed when RUN_SEED=true or DEMO_MODE=true
if [ "${FORCE_RESEED:-false}" = "true" ]; then
    php artisan migrate:fresh --seed --force
elif [ "${RUN_SEED:-false}" = "true" ] || [ "${DEMO_MODE:-false}" = "true" ]; then
    SEED_STATE=$(php -r "
        require 'vendor/autoload.php';
        \$app = require 'bootstrap/app.php';
        \$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
        \$kernel->bootstrap();
        if (!\App\Models\User::query()->exists()) {
            echo 'empty';
            exit;
        }
        \$activeYear = \Illuminate\Support\Facades\DB::table('configs')->where('status', '1')->value('tahun');
        \$indCount = \$activeYear
            ? \Illuminate\Support\Facades\DB::table('indikators')->where('kode', 'like', '%'.\$activeYear)->count()
            : 0;
        if (\$indCount < 15) {
            echo 'stale';
            exit;
        }
        \$d01Exceed = \$activeYear
            ? \Illuminate\Support\Facades\DB::table('triwulan2s')
                ->where('kode', 'like', '01%'.\$activeYear)
                ->where('status', 'Melampaui Target')
                ->count()
            : 0;
        \$d02Exceed = \$activeYear
            ? \Illuminate\Support\Facades\DB::table('triwulan2s')
                ->where('kode', 'like', '02%'.\$activeYear)
                ->where('status', 'Melampaui Target')
                ->count()
            : 0;
        if (\$d01Exceed === 3 && \$d02Exceed === 3) {
            echo 'stale';
            exit;
        }
        echo 'ok';
    " 2>/dev/null || echo "ok")

    if [ "$SEED_STATE" = "empty" ]; then
        php artisan db:seed --force
    elif [ "$SEED_STATE" = "stale" ]; then
        php artisan migrate:fresh --seed --force
    fi
fi

exec apache2-foreground
