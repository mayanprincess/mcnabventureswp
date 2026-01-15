<?php
/**
 * WordPress Production Configuration (Docker)
 *
 * Uses environment variables for DB + salts.
 */

// DB env sources we support (Railway friendly):
// - WORDPRESS_DB_HOST / WORDPRESS_DB_NAME / WORDPRESS_DB_USER / WORDPRESS_DB_PASSWORD
// - MYSQLHOST / MYSQLPORT / MYSQLDATABASE / MYSQLUSER / MYSQLPASSWORD
// - MYSQL_DATABASE / MYSQL_USER / MYSQL_PASSWORD / DB_HOST   (common Railway template vars)
// - MYSQL_URL or DATABASE_URL in the form: mysql://user:pass@host:port/db

$db_host = getenv('WORDPRESS_DB_HOST') ?: '';
$db_name = getenv('WORDPRESS_DB_NAME') ?: '';
$db_user = getenv('WORDPRESS_DB_USER') ?: '';
$db_pass = getenv('WORDPRESS_DB_PASSWORD') ?: '';

// 1) Parse connection string if present
$conn = getenv('MYSQL_URL') ?: getenv('DATABASE_URL') ?: '';
if ((!$db_host || !$db_name || !$db_user) && $conn && strpos($conn, 'mysql://') === 0) {
  $parts = parse_url($conn);
  if (is_array($parts)) {
    $conn_host = $parts['host'] ?? '';
    $conn_port = $parts['port'] ?? '';
    $conn_user = $parts['user'] ?? '';
    $conn_pass = $parts['pass'] ?? '';
    $conn_path = $parts['path'] ?? '';
    $conn_db = ltrim($conn_path, '/');

    if (!$db_host && $conn_host) {
      $db_host = $conn_host . ($conn_port ? ':' . $conn_port : '');
    }
    if (!$db_name && $conn_db) {
      $db_name = $conn_db;
    }
    if (!$db_user && $conn_user) {
      $db_user = $conn_user;
    }
    if (!$db_pass && $conn_pass) {
      $db_pass = $conn_pass;
    }
  }
}

// 2) Fallback to Railway-style discrete vars (both naming styles)
// IMPORTANT: We do NOT default to dummy credentials in prod. Missing env vars should fail fast.
if (!$db_name) $db_name = getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: '';
if (!$db_user) $db_user = getenv('MYSQLUSER') ?: getenv('MYSQL_USER') ?: '';
if (!$db_pass) $db_pass = getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD') ?: '';

if (!$db_host) {
  // Some Railway templates provide DB_HOST already (often includes host:port)
  $db_host = getenv('DB_HOST') ?: '';
  if ($db_host) {
    // keep as-is
  } else {
  $mysql_host = getenv('MYSQLHOST') ?: '';
  $mysql_port = getenv('MYSQLPORT') ?: '';
  if ($mysql_host && $mysql_port) {
    $db_host = $mysql_host . ':' . $mysql_port;
  } elseif ($mysql_host) {
    $db_host = $mysql_host;
  } else {
    $db_host = '';
  }
  }
}

// Fail fast if DB env vars are missing/mismatched.
// This prevents WordPress from silently using wrong defaults and showing a generic DB error.
$has_any_db_env =
  getenv('WORDPRESS_DB_HOST') || getenv('WORDPRESS_DB_NAME') || getenv('WORDPRESS_DB_USER') || getenv('WORDPRESS_DB_PASSWORD') ||
  getenv('MYSQL_URL') || getenv('DATABASE_URL') ||
  getenv('DB_HOST') ||
  getenv('MYSQLHOST') || getenv('MYSQLPORT') ||
  getenv('MYSQLDATABASE') || getenv('MYSQL_DATABASE') ||
  getenv('MYSQLUSER') || getenv('MYSQL_USER') ||
  getenv('MYSQLPASSWORD') || getenv('MYSQL_PASSWORD');

if (!$has_any_db_env || !$db_host || !$db_name || !$db_user) {
  header('Content-Type: text/plain', true, 500);
  echo "Missing database environment variables.\n\n";
  echo "Provide ONE of the following sets:\n";
  echo "- WORDPRESS_DB_HOST, WORDPRESS_DB_NAME, WORDPRESS_DB_USER, WORDPRESS_DB_PASSWORD\n";
  echo "- MYSQL_URL (mysql://user:pass@host:port/db)  (or DATABASE_URL)\n";
  echo "- DB_HOST, MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD\n";
  echo "- MYSQLHOST, MYSQLPORT, MYSQLDATABASE, MYSQLUSER, MYSQLPASSWORD\n\n";
  echo "Resolved values:\n";
  echo "DB_HOST=" . ($db_host ?: '(empty)') . \"\\n\";
  echo "DB_NAME=" . ($db_name ?: '(empty)') . \"\\n\";
  echo "DB_USER=" . ($db_user ?: '(empty)') . \"\\n\";
  exit(1);
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

