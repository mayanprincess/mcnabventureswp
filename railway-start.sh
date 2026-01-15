#!/usr/bin/env bash
set -euo pipefail

# Run the official WordPress entrypoint logic once to:
# - copy WP core from /usr/src/wordpress -> /var/www/html if missing
# - perform any required setup
#
# We run it in a subshell because it `exec`s the command you pass.
# `php-fpm -D` daemonizes and returns, leaving php-fpm running.
( /usr/local/bin/docker-entrypoint.sh php-fpm -D )

# Render nginx config with Railway PORT
export PORT="${PORT:-8080}"
envsubst '${PORT}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

# Ensure nginx runtime dirs exist
mkdir -p /run/nginx

# Run nginx in foreground
exec nginx -g 'daemon off;'

