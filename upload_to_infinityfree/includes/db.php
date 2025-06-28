<?php 
// No need to include config.php here, it will be handled by bootstrap.php

// Enable mysqli error reporting for development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Use the constants defined in config/config.php for the connection
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
    // A more user-friendly error for production environments
    // In development, you can still log the full error: error_log($e->getMessage());
    die("Database connection failed. Please try again later.");
}
?>