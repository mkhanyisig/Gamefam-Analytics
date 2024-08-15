#!/bin/bash

# Start cron
cron -f &
# Run Laravel schedule:work
php /var/www/html/artisan schedule:work