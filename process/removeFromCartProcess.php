<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';


if (isset($_POST['id'])) {
    $cart_item_id = $_POST['id'];

    // Ensure user is logged in before proceeding
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User not logged in.";
        exit;
    }
    // Call the function and check its return value
    if (removeFromCart($connection, $cart_item_id)) {
        echo "success";
    } else {
        echo "Error: Failed to remove item from the database.";
    }
    exit;
}

