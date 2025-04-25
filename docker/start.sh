#!/bin/bash

# Wait for the database to be ready
echo "Waiting for database connection..."
while ! php artisan db:monitor > /dev/null 2>&1; do
    sleep 1
done

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Start PHP server
echo "Starting PHP server..."
php artisan serve --host=0.0.0.0 --port=$PORT 