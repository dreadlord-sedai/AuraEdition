<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Get input from the POST request (form data)
$cart_item_id = $_POST['cart_item_id'] ?? null;
$action = $_POST['action'] ?? null;

if (!$cart_item_id || !$action || !in_array($action, ['increment', 'decrement'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Find the user's cart ID
$cart_stmt = $connection->prepare("SELECT cart_id FROM carts WHERE user_id = ?");
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();
$cart = $cart_result->fetch_assoc();
$cart_stmt->close();

if (!$cart) {
    echo json_encode(['success' => false, 'message' => 'Cart not found.']);
    exit;
}
$cart_id = $cart['cart_id'];

// Use a transaction to ensure data integrity
$connection->begin_transaction();

try {
    // Get the max stock for this cart item
    $stock_stmt = $connection->prepare("SELECT p.stock FROM cart_items ci JOIN vehicles p ON ci.vehicle_id = p.id WHERE ci.cart_id = ? AND ci.cart_item_id = ?");
    $stock_stmt->bind_param("ii", $cart_id, $cart_item_id);
    $stock_stmt->execute();
    $stock_result = $stock_stmt->get_result();
    $stock_row = $stock_result->fetch_assoc();
    $stock_stmt->close();
    $max_stock = $stock_row['stock'] ?? 1;

    if ($action === 'increment') {
        // Only increment if current quantity is less than stock
        $qty_stmt = $connection->prepare("SELECT quantity FROM cart_items WHERE cart_id = ? AND cart_item_id = ?");
        $qty_stmt->bind_param("ii", $cart_id, $cart_item_id);
        $qty_stmt->execute();
        $qty_result = $qty_stmt->get_result();
        $qty_row = $qty_result->fetch_assoc();
        $qty_stmt->close();
        $current_qty = $qty_row['quantity'] ?? 1;
        if ($current_qty < $max_stock) {
            $stmt = $connection->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE cart_id = ? AND cart_item_id = ?");
            $stmt->bind_param("ii", $cart_id, $cart_item_id);
            $stmt->execute();
        }
    } elseif ($action === 'decrement') {
        // To prevent quantity from going below 1, we only update if it's greater than 1.
        $stmt = $connection->prepare("UPDATE cart_items SET quantity = GREATEST(1, quantity - 1) WHERE cart_id = ? AND cart_item_id = ?");
        $stmt->bind_param("ii", $cart_id, $cart_item_id);
        $stmt->execute();
    }

    // Fetch the new quantity to send back to the browser
    $final_qty_stmt = $connection->prepare("SELECT quantity FROM cart_items WHERE cart_id = ? AND cart_item_id = ?");
    $final_qty_stmt->bind_param("ii", $cart_id, $cart_item_id);
    $final_qty_stmt->execute();
    $final_qty_result = $final_qty_stmt->get_result();
    $final_item = $final_qty_result->fetch_assoc();
    $final_qty_stmt->close();

    $connection->commit();

    echo json_encode(['success' => true, 'newQuantity' => $final_item['quantity'] ?? 0]);

} catch (Exception $e) {
    $connection->rollback();
    error_log("Cart update failed: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'A database error occurred.']);
}

$connection->close();