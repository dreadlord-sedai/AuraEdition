<?php
/**
 * Application Bootstrap
 *
 * This file is the single entry point for loading all core application files.
 * It ensures that sessions are started, configuration is loaded, the database
 * is connected, and all helper functions are available for every page.
 */

// Set the default timezone to prevent potential date/time issues.
date_default_timezone_set('UTC');

// Start the session manager.
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/session.php';

// Load global configuration (DB credentials, paths, etc.).
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Establish the database connection.
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';

// Load application-wide helper functions (auth, flash messages, etc.).
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth_helpers.php';

?> 
