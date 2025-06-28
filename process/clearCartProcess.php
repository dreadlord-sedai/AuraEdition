<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/error_log.txt');
header('Content-Type: application/json');
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["status" => "error", "message" => "Invalid request method"]);
        exit;
    }

    // Clear the vehicles and total_price from session
    unset($_SESSION['vehicles']);
    unset($_SESSION['total_price']);
    
    // Optionally, clear the cart in the database for logged-in users
    if (isset($_SESSION['user_id'])) {
        clearCart($connection, $_SESSION['user_id']);
    }
    
    echo json_encode(["status" => "success"]);
    exit;
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}
?>
