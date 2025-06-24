<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

if (isset($_POST['vehicle_id'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $quantity = isset($_POST['quantity']) && is_numeric($_POST['quantity']) && $_POST['quantity'] > 0 ? intval($_POST['quantity']) : 1;

    // Ensure user is logged in before proceeding
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User not logged in.";
        exit;
    }


    if (cartExists($connection, $_SESSION['user_id']) === true) {
        $user_id = $_SESSION['user_id'];

        if (addToCart($connection, $user_id, $vehicle_id, $quantity)) {
            echo "success";
        } else {
            echo "Error: Failed to add vehicle to cart.";
        }
    } else {
        createCart($connection, $_SESSION['user_id']);
    }
}
