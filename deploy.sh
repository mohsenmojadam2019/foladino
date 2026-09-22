#!/usr/bin/env bash
set -euo pipefail
php artisan down || true
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan storage:link || true
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart || true
php artisan up
