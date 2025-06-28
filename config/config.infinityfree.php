<?php
/**
 * InfinityFree Configuration File
 *
 * Update these values with your InfinityFree database credentials
 */

// --- Database Configuration ---
define('DB_HOST', 'your-mysql-host.infinityfree.com');
define('DB_USER', 'yourname_auraedition_user');
define('DB_PASS', 'your-database-password');
define('DB_NAME', 'yourname_auraedition');

// --- Path and URL Configuration ---
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
define('BASE_URL', 'https://yourname.infinityfree.com');

// --- Production Settings ---
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

?>
