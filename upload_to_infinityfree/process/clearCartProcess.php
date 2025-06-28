<?php
header('Content-Type: application/json');
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Clear the vehicles and total_price from session
    unset($_SESSION['vehicles']);
    unset($_SESSION['total_price']);

    // Optionally, clear the cart in the database for logged-in users
    if (isset($_SESSION['user_id'])) {
        clearCart($connection, $_SESSION['user_id']);
    }

    echo json_encode(["status" => "success"]);
    exit;
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
?>
