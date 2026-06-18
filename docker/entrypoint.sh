#!/usr/bin/env bash
# Rejoice Pages container entrypoint.
# Prepares writable paths, generates an APP_KEY, and (by default) performs a
# non-interactive first-run install so the app is usable immediately. Set
# AUTO_INSTALL=false to instead complete setup through the LinkStack web installer.
set -euo pipefail

cd /var/www/html

APP_ROOT=/var/www/html
INSTALL_MARKER="$APP_ROOT/storage/app/ISINSTALLED"
AUTO_INSTALL="${AUTO_INSTALL:-true}"

# Ensure a .env exists (the repo ships one; fall back to the example).
if [ ! -f "$APP_ROOT/.env" ]; then
    cp "$APP_ROOT/.env.example" "$APP_ROOT/.env"
fi

# For sqlite (the default), make sure the database file exists.
if grep -qE '^DB_CONNECTION=sqlite' "$APP_ROOT/.env" 2>/dev/null || [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    touch "$APP_ROOT/database/database.sqlite"
fi

# Make runtime paths writable (important when volumes are mounted).
chown -R www-data:www-data "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache" \
    "$APP_ROOT/database" "$APP_ROOT/.env" "$APP_ROOT/config" 2>/dev/null || true
chmod -R 775 "$APP_ROOT/storage" "$APP_ROOT/bootstrap/cache" "$APP_ROOT/database" 2>/dev/null || true

run_artisan() { su -s /bin/bash www-data -c "php artisan $*"; }

# Generate an APP_KEY if one isn't set.
if ! grep -qE '^APP_KEY=base64:' "$APP_ROOT/.env" 2>/dev/null; then
    run_artisan key:generate --force
fi

if [ "$AUTO_INSTALL" = "true" ] && [ ! -f "$INSTALL_MARKER" ]; then
    echo "[rejoice] First run: installing…"
    run_artisan migrate --force
    run_artisan db:seed --class=ButtonSeeder --force
    run_artisan db:seed --class=AdminSeeder --force

    # Optionally set the admin credentials from the environment.
    if [ -n "${ADMIN_EMAIL:-}" ] || [ -n "${ADMIN_PASSWORD:-}" ]; then
        run_artisan tinker --execute="
            \$u = App\\Models\\User::where('name','admin')->first();
            if (\$u) {
                if (getenv('ADMIN_EMAIL')) { \$u->email = getenv('ADMIN_EMAIL'); }
                if (getenv('ADMIN_PASSWORD')) { \$u->password = Illuminate\\Support\\Facades\\Hash::make(getenv('ADMIN_PASSWORD')); }
                \$u->email_verified_at = now();
                \$u->save();
            }
        "
    fi

    # Optionally seed the demo pages.
    if [ "${SEED_DEMO:-false}" = "true" ]; then
        run_artisan db:seed --class=RejoiceDemoSeeder --force
    fi

    su -s /bin/bash www-data -c "touch '$INSTALL_MARKER'"
    rm -f "$APP_ROOT/INSTALLING"
    echo "[rejoice] Install complete."
fi

# Cache framework config/routes/views for production performance.
if [ "${OPTIMIZE:-true}" = "true" ] && [ -f "$INSTALL_MARKER" ]; then
    run_artisan config:clear || true
    run_artisan route:cache || true
    run_artisan view:cache || true
fi

exec "$@"
