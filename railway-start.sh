#!/usr/bin/env bash
set -euo pipefail

# Defaults (can be overridden via Railway Variables)
export PORT="${PORT:-8080}"
export CLIENT_MAX_BODY_SIZE="${CLIENT_MAX_BODY_SIZE:-128m}"
export PHP_UPLOAD_MAX_FILESIZE="${PHP_UPLOAD_MAX_FILESIZE:-128M}"
export PHP_POST_MAX_SIZE="${PHP_POST_MAX_SIZE:-128M}"
export PHP_MEMORY_LIMIT="${PHP_MEMORY_LIMIT:-512M}"
export PHP_MAX_EXECUTION_TIME="${PHP_MAX_EXECUTION_TIME:-300}"
export PHP_MAX_INPUT_TIME="${PHP_MAX_INPUT_TIME:-300}"
export PHP_MAX_INPUT_VARS="${PHP_MAX_INPUT_VARS:-5000}"

# Write PHP overrides (php.ini) at runtime
cat > /usr/local/etc/php/conf.d/zz-railway-limits.ini <<EOF
upload_max_filesize=${PHP_UPLOAD_MAX_FILESIZE}
post_max_size=${PHP_POST_MAX_SIZE}
memory_limit=${PHP_MEMORY_LIMIT}
max_execution_time=${PHP_MAX_EXECUTION_TIME}
max_input_time=${PHP_MAX_INPUT_TIME}
max_input_vars=${PHP_MAX_INPUT_VARS}
EOF

# Run the official WordPress entrypoint logic once to:
# - copy WP core from /usr/src/wordpress -> /var/www/html if missing
# - perform any required setup
#
# We run it in a subshell because it `exec`s the command you pass.
# `php-fpm -D` daemonizes and returns, leaving php-fpm running.
( /usr/local/bin/docker-entrypoint.sh php-fpm -D )

# Render nginx config with Railway PORT
envsubst '${PORT} ${CLIENT_MAX_BODY_SIZE}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

# Ensure nginx runtime dirs exist
mkdir -p /run/nginx

# Run nginx in foreground
exec nginx -g 'daemon off;'

