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
FROM wordpress:6.4.3-php8.2-apache

# Fix: "More than one MPM loaded" (ensure only one Apache MPM is enabled)
# WordPress Apache images should use prefork; disable event/worker if present.
RUN a2dismod mpm_event mpm_worker >/dev/null 2>&1 || true \
  && a2enmod mpm_prefork >/dev/null 2>&1 || true

# Prod wp-config uses environment variables for secrets.
COPY wp-config.prod.php /var/www/html/wp-config.php

# Theme (with compiled CSS)
COPY --from=assets /app/mcnabventures /var/www/html/wp-content/themes/mcnabventures
# Composer vendor into theme
COPY --from=composer_deps /app/vendor /var/www/html/wp-content/themes/mcnabventures/vendor

# Plugins (drop ACF PRO, etc. into ./plugins locally before building)
COPY plugins /var/www/html/wp-content/plugins

RUN chown -R www-data:www-data /var/www/html/wp-content

