############################################
# Production image for WordPress + McNab theme
# - Builds SCSS (sass:build)
# - Installs Composer deps for Timber
# - Copies theme + plugins into the image
############################################

############################
# 1) Build assets (Sass)
############################
FROM node:20-alpine AS assets
WORKDIR /app

COPY mcnabventures/package.json mcnabventures/package-lock.json ./
RUN npm ci

COPY mcnabventures ./mcnabventures
WORKDIR /app/mcnabventures
RUN npm run sass:build

############################
# 2) Build PHP deps (Composer)
############################
FROM composer:2 AS composer_deps
WORKDIR /app

# Install from lockfile for deterministic builds
COPY mcnabventures/composer.json mcnabventures/composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-security-blocking

############################
# 3) Runtime (WordPress)
############################
FROM wordpress:6.4.3-php8.2-fpm

# NOTE:
# For the FPM image, Nginx will serve static files and forward PHP to php-fpm.
# We copy theme/plugins into /usr/src/wordpress so the official entrypoint copies
# them into /var/www/html (the shared volume) on first run.

# Prod wp-config uses environment variables for secrets.
COPY wp-config.prod.php /usr/src/wordpress/wp-config.php

# Theme (with compiled CSS)
COPY --from=assets /app/mcnabventures /usr/src/wordpress/wp-content/themes/mcnabventures
# Composer vendor into theme
COPY --from=composer_deps /app/vendor /usr/src/wordpress/wp-content/themes/mcnabventures/vendor

# Plugins (drop ACF PRO, etc. into ./plugins locally before building)
COPY plugins /usr/src/wordpress/wp-content/plugins


