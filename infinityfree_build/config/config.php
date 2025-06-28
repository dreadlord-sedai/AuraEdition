<?php
/**
 * Global Configuration File
 *
 * This file centralizes all the core configuration for the application,
 * making it easy to manage settings like database credentials and base paths.
 */

// --- Database Configuration ---
// Define your database connection details as constants.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'mysql2006');
define('DB_NAME', 'auraedition');

// --- Path and URL Configuration ---
// Define the project's root path and base URL to build reliable links and includes.
// The DOCUMENT_ROOT is used to create an absolute path from the server's root.
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/Projects/AuraEdition');

?> 