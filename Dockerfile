FROM php:8.1-apache

# System dependencies for Laravel, PhpSpreadsheet, and wkhtmltopdf
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    ca-certificates \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libxrender1 \
    libfontconfig1 \
    libxext6 \
    libx11-6 \
    fontconfig \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        xml \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite/headers and serve from /var/www/html/public
RUN a2enmod rewrite headers \
    && sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies first for Docker layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copy application source
COPY . .

# Generate optimized autoloader, discover packages, and mark Linux wkhtmltopdf binaries executable
RUN composer dump-autoload --optimize --no-dev \
    && php artisan package:discover --ansi \
    && if [ -f vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64 ]; then chmod +x vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64; fi \
    && if [ -f vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64 ]; then chmod +x vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64; fi

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
