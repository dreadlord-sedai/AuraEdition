<?php 
// No need to include config.php here, it will be handled by bootstrap.php

// Enable mysqli error reporting for development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Use the constants defined in config/config.php for the connection
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check if connection was successful
    if (!$connection) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    
} catch (Exception $e) {
    // For debugging - show the actual error
    die("Database connection failed: " . $e->getMessage());
    
    // Once fixed, change back to this user-friendly message:
    // die("Database connection failed. Please try again later.");
}
?>
