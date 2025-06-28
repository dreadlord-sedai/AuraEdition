<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';

if (isset($_POST['vehicle_id']) && isset($_SESSION['user_id'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $user_id = $_SESSION['user_id'];

    addToWishlist($connection, $user_id, $vehicle_id);

    echo "success";
}
