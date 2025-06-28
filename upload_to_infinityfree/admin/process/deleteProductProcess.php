<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserWithAddress($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] != "admin") {
    header("Location: /index.php");
    exit;
}

if (isset($_POST['id'])) {
    $product_id = $_POST['id'];

    // Delete product
    deleteProductImage($connection, $product_id);
    deleteProduct($connection, $product_id);
}

exit;
