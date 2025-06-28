<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';

if (isset($_POST['id'])) {
    $vehicle_id = $_POST['id'];
    removeFromWishlist($connection, $vehicle_id);
    echo "success";
} else {
    echo "error";
}
