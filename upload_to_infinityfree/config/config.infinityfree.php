<?php
/**
 * InfinityFree Configuration File
 *
 * Update these values with your InfinityFree database credentials
 */

// --- Database Configuration ---
define('DB_HOST', 'sql101.infinityfree.com');
define('DB_USER', 'if0_39343562');
define('DB_PASS', 'b8Ud7jYGRVW1EfC');
define('DB_NAME', 'https://auraedition.infinityfreeapp.com/');

// --- Path and URL Configuration ---
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
define('BASE_URL', 'https://yourname.infinityfree.com');

// --- Production Settings ---
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

?>
