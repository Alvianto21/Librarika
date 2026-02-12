#!/bin/bash

if [ ! -f storage/framework/cache/.gitignore ]; then
  php artisan route:cache
  php artisan view:cache
  php artisan event:cache
fi

exec "$@"