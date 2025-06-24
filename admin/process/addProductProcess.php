<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserInfo($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] != "admin") {
    header("Location: /Projects/AuraEdition/index.php");
    exit;
}

if (isset($_POST['update_product'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $make = $_POST['make'];
    $model = $_POST['model'];

    // Validate inputs
    if (empty($title) || empty($description) || empty($price) || empty($stock) || empty($make) || empty($model)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: /Projects/AuraEdition/admin/pages/editProduct.php?product_id=" . $product_id);
        exit;
    }

    addProduct($connection,  $title, $description, $price, $stock, $make, $model);
}

handleProductImageUpload($_FILES['image'], $product_id, $connection);

exit;
