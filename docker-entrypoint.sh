#!/bin/bash

# wait for PostgreSQL to start
function postgres_ready() {
    php bin/console doctrine:query:sql "SELECT 1" >/dev/null 2>&1
}

until postgres_ready; do
    sleep 1
    echo "Waiting for PostgreSQL to start..."
done

# run migrations
php bin/console doctrine:migrations:migrate --no-interaction
