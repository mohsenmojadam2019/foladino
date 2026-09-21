FROM php:8.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libonig-dev libxml2-dev libzip-dev libsqlite3-dev curl \
    && docker-php-ext-install pdo_sqlite mbstring bcmath \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer dump-autoload --no-dev --optimize \
    && if [ ! -f .env ]; then cp .env.example .env; fi \
    && mkdir -p database storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && touch database/database.sqlite \
    && chmod -R 777 storage database

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000

