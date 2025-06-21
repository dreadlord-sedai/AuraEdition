<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicle_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($vehicle_id <= 0 || $quantity < 1) {
        echo "Invalid input";
        exit;
    }

    if (!isset($_SESSION['vehicles']) || count($_SESSION['vehicles']) === 0) {
        echo "Cart is empty";
        exit;
    }

    // Update quantity in session vehicles
    foreach ($_SESSION['vehicles'] as &$vehicle) {
        if ($vehicle['id'] == $vehicle_id) {
            $vehicle['quantity'] = $quantity;
            break;
        }
    }
    unset($vehicle);

    // Recalculate total price
    $total_price = 0;
    foreach ($_SESSION['vehicles'] as $vehicle) {
        $price = isset($vehicle['price']) ? $vehicle['price'] : 0;
        $qty = isset($vehicle['quantity']) ? $vehicle['quantity'] : 1;
        $total_price += $price * $qty;
    }
    $_SESSION['total_price'] = $total_price;

    echo "success";
    exit;
} else {
    echo "Invalid request method";
    exit;
}
?>
