<?php
/**
 * InfinityFree Configuration File
 *
 * Update these values with your InfinityFree database credentials
 */

// --- Database Configuration ---
define('DB_HOST', 'sql102.infinityfree.com');
define('DB_USER', 'if0_39345541');
define('DB_PASS', '9ipSx4cnhHLj0OD');
define('DB_NAME', 'if0_39345541_auraedition');

// --- Path and URL Configuration ---
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
define('BASE_URL', 'https://auraedition.wuaze.com');

// --- Production Settings ---
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

?>
