<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';


if (isset($_POST['id'])) {
    $vehicle_id = $_POST['id'];

    // Ensure user is logged in before proceeding
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User not logged in.";
        exit;
    }
    $user_id = $_SESSION['user_id'];
    // Call the function and check its return value
    if (removeFromCart($connection, $user_id, $vehicle_id)) {
        echo "success"; // Send the expected response to JavaScript
    } else {
        echo "Error: Failed to remove item from the database.";
    }

    exit;
}

