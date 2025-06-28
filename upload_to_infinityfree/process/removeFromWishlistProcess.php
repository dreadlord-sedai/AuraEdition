<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

if (isset($_POST['id'])) {
    $vehicle_id = $_POST['id'];
    removeFromWishlist($connection, $vehicle_id);
    echo "success";
} else {
    echo "error";
}
