<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$vehicle_id = $input['vehicle_id'] ?? null;

if (!$vehicle_id) {
    echo json_encode(['success' => false, 'message' => 'Vehicle ID not provided.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Find the user's cart ID
$cart_stmt = $connection->prepare("SELECT id FROM carts WHERE user_id = ?");
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();
$cart = $cart_result->fetch_assoc();
$cart_stmt->close();

if (!$cart) {
    echo json_encode(['success' => false, 'message' => 'Cart not found.']);
    exit;
}
$cart_id = $cart['id'];

// Delete the item from the cart
$stmt = $connection->prepare("DELETE FROM cart_items WHERE cart_id = ? AND vehicle_id = ?");
$stmt->bind_param("ii", $cart_id, $vehicle_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    error_log("Remove from cart failed: " . $stmt->error);
    echo json_encode(['success' => false, 'message' => 'Failed to remove item from cart.']);
}

$stmt->close();
$connection->close();