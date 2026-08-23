<?php
/**
 * Global Configuration File
 *
 * This file centralizes all the core configuration for the application,
 * making it easy to manage settings like database credentials and base paths.
 */

// --- Database Configuration ---
// Define your database connection details as constants.
// NOTE: 127.0.0.1 (TCP) instead of 'localhost' — XAMPP's PHP resolves
// 'localhost' to XAMPP's own socket (/opt/lampp/var/mysql/mysql.sock),
// which only exists when XAMPP's bundled MySQL server is running. TCP
// targets the system MySQL service on port 3306 instead.
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', 'mysql2006');
define('DB_NAME', 'auraedition');

// --- Path and URL Configuration ---
// Define the project's root path and base URL to build reliable links and includes.
// The DOCUMENT_ROOT is used to create an absolute path from the server's root.
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/Projects/AuraEdition');

?> 