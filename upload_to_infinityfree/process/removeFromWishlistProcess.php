<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/session.php';

if (isset($_POST['id'])) {
    $vehicle_id = $_POST['id'];
    removeFromWishlist($connection, $vehicle_id);
    echo "success";
} else {
    echo "error";
}
