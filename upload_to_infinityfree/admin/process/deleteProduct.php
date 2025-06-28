<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminFunctions.php';

$user = authorize_admin($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = (int)$_POST['product_id'];
    
    // First, delete the associated image file if it exists
    // (This part requires you to have a function to get the image path before deleting the product record)
    // For now, we just delete the DB records
    
    deleteProductImage($connection, $product_id); // From vehicle_images
    deleteProduct($connection, $product_id);      // From vehicles

    set_flash('success', 'Product deleted successfully.');
    header("Location: " . BASE_URL . "/admin/pages/vehicles.php");
    exit();
} else {
    header("Location: " . BASE_URL . "/admin/pages/vehicles.php");
    exit();
} 
