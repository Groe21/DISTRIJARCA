#!/bin/sh
cd backend/distrijarca-api
php artisan migrate --force
php artisan db:seed --class=UserSeeder --force
php artisan storage:link
exec php -S 0.0.0.0:${PORT:-8000} -t public public/index.php
