<?php 

$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'mysql2006';
$db_name = 'auraedition';

// Enable mysqli error reporting for development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // Connection successful
} catch (mysqli_sql_exception $e) {
    die("Database connection failed: " . $e->getMessage());
}


?>