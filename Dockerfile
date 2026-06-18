# Rejoice Pages — production image
# Runs the Laravel (LinkStack-based) app on Apache with the project root as the
# document root (LinkStack's shared-hosting layout: index.php + .htaccess at root).
FROM php:8.2-apache

# --- System dependencies & PHP extensions -----------------------------------
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip \
        libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
        libzip-dev libonig-dev libicu-dev libxml2-dev \
        libcurl4-openssl-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath gd zip exif intl mbstring pdo_mysql pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# --- Apache configuration ----------------------------------------------------
# Document root is the project root; allow .htaccess overrides for rewrites.
RUN a2enmod rewrite \
    && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf \
    && printf 'ServerName localhost\n' > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

# --- PHP runtime configuration ----------------------------------------------
RUN { \
        echo 'memory_limit=512M'; \
        echo 'upload_max_filesize=64M'; \
        echo 'post_max_size=64M'; \
        echo 'max_execution_time=120'; \
    } > /usr/local/etc/php/conf.d/rejoice.ini

# --- Composer ----------------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# Install PHP dependencies first (better layer caching).
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --prefer-dist

# Copy the application and finish the autoloader.
COPY . .
RUN composer dump-autoload --no-dev --optimize --no-interaction \
    && php artisan package:discover --ansi || true

# --- Permissions -------------------------------------------------------------
# The installer and runtime write to .env, config, storage, and the sqlite DB.
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache database

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
