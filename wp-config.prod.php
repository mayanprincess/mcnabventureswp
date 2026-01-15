<?php
/**
 * WordPress Production Configuration (Docker)
 *
 * Uses environment variables for DB + salts.
 */

// Railway MySQL commonly provides: MYSQLHOST, MYSQLPORT, MYSQLUSER, MYSQLPASSWORD, MYSQLDATABASE
// Our compose/prod setup uses: WORDPRESS_DB_HOST, WORDPRESS_DB_NAME, WORDPRESS_DB_USER, WORDPRESS_DB_PASSWORD
$db_name = getenv('WORDPRESS_DB_NAME') ?: getenv('MYSQLDATABASE') ?: 'wordpress';
$db_user = getenv('WORDPRESS_DB_USER') ?: getenv('MYSQLUSER') ?: 'wordpress';
$db_pass = getenv('WORDPRESS_DB_PASSWORD') ?: getenv('MYSQLPASSWORD') ?: 'wordpress_pass';

$db_host = getenv('WORDPRESS_DB_HOST');
if (!$db_host) {
  $mysql_host = getenv('MYSQLHOST');
  $mysql_port = getenv('MYSQLPORT');
  if ($mysql_host && $mysql_port) {
    $db_host = $mysql_host . ':' . $mysql_port;
  } elseif ($mysql_host) {
    $db_host = $mysql_host;
  } else {
    $db_host = 'db:3306';
  }
}

define('DB_NAME', $db_name);
define('DB_USER', $db_user);
define('DB_PASSWORD', $db_pass);
define('DB_HOST', $db_host);
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

