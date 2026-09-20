#!/bin/sh
set -e

php artisan config:clear

if [ ! -L public/storage ]; then
    php artisan storage:link
fi

php artisan migrate --force
php artisan app:seed-once

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
