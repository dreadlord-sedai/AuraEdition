<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || !isset($_POST['quantity'])) {
        echo "Error: Missing parameters";
        exit;
    }

    $vehicle_id = $_POST['id'];
    $quantity = intval($_POST['quantity']);
    if ($quantity < 1) {
        echo "Error: Invalid quantity";
        exit;
    }

    if (!isset($_SESSION['vehicles'])) {
        echo "Error: No vehicles in session";
        exit;
    }

    $found = false;
    foreach ($_SESSION['vehicles'] as &$vehicle) {
        if ($vehicle['id'] == $vehicle_id) {
            $vehicle['quantity'] = $quantity;
            $found = true;
            break;
        }
    }
    unset($vehicle);

    if (!$found) {
        echo "Error: Vehicle not found in session";
        exit;
    }

    // Recalculate total price
    $total_price = 0;
    foreach ($_SESSION['vehicles'] as $vehicle) {
        $qty = isset($vehicle['quantity']) ? $vehicle['quantity'] : 1;
        $total_price += $vehicle['price'] * $qty;
    }
    $_SESSION['total_price'] = $total_price;

    echo "success";
    exit;
} else {
    echo "Invalid request method";
    exit;
}
?>
