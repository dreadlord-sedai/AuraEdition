<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';


if (isset($_POST['vehicle_id'])) {
    $vehicle_id = $_POST['vehicle_id'];
    removeFromCart($connection, $vehicle_id);
    header("Location: /Projects/AuraEdition/pages/cart.php");
    exit;
}

