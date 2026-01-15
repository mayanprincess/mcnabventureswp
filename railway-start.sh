#!/usr/bin/env bash
set -euo pipefail

# Render nginx config with Railway PORT
export PORT="${PORT:-8080}"
envsubst '${PORT}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

# Ensure nginx runtime dirs exist
mkdir -p /run/nginx

# Start php-fpm in background (image provides php-fpm)
php-fpm -D

# Run nginx in foreground
exec nginx -g 'daemon off;'

