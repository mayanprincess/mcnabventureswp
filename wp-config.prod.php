<?php
/**
 * WordPress Production Configuration (Docker)
 *
 * Uses environment variables for DB + salts.
 */

define('DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'wordpress');
define('DB_USER', getenv('WORDPRESS_DB_USER') ?: 'wordpress');
define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'wordpress_pass');
define('DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'db:3306');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

$table_prefix = getenv('WORDPRESS_TABLE_PREFIX') ?: 'wp_';

// Debug (default off in prod)
define('WP_DEBUG', filter_var(getenv('WP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_LOG', filter_var(getenv('WP_DEBUG_LOG') ?: false, FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

// Salts (MUST be provided via env in prod)
define('AUTH_KEY',         getenv('AUTH_KEY') ?: 'change-me');
define('SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY') ?: 'change-me');
define('LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY') ?: 'change-me');
define('NONCE_KEY',        getenv('NONCE_KEY') ?: 'change-me');
define('AUTH_SALT',        getenv('AUTH_SALT') ?: 'change-me');
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT') ?: 'change-me');
define('LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT') ?: 'change-me');
define('NONCE_SALT',       getenv('NONCE_SALT') ?: 'change-me');

if (!defined('ABSPATH')) {
  define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';

