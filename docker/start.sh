#!/bin/bash

# Wait for the database to be ready
echo "Waiting for database connection..."
while ! php artisan db:monitor > /dev/null 2>&1; do
    sleep 1
done

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Configure Apache port
echo "Configuring Apache port..."
sed -i "s/\${PORT}/$PORT/g" /etc/apache2/sites-available/000-default.conf
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf

# Start Apache
echo "Starting Apache..."
apache2-ctl -D FOREGROUND 