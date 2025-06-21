<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_SESSION['vehicles']) || count($_SESSION['vehicles']) === 0) {
            echo "Error: Cart is empty";
            exit;
        }

        // 1. Get cart items from session
        $vehicles = $_SESSION['vehicles'];
        $total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;

        // 2. Process the payment
        // For this example, we simulate payment success
        $payment_success = true;

        if (!$payment_success) {
            echo "Error: Payment failed";
            exit;
        }

        // 3. Create order record in database
        // Assuming you have an orders table and order_items table
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if (!$user_id) {
            echo "Error: User not logged in";
            exit;
        }

        $connection->begin_transaction();

        $stmt = $connection->prepare("INSERT INTO orders (user_id, total_price, orderd_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $user_id, $total_price);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        $stmt_item = $connection->prepare("INSERT INTO order_items (order_id, vehicle_id, price) VALUES (?, ?, ?)");
        foreach ($vehicles as $vehicle) {
            $stmt_item->bind_param("iid", $order_id, $vehicle['id'], $vehicle['price']);
            $stmt_item->execute();
        }
        $stmt_item->close();

        $connection->commit();

        // 4. Clear the cart
        unset($_SESSION['vehicles']);
        unset($_SESSION['total_price']);

        echo "success";
        exit;
    } catch (Exception $e) {
        $connection->rollback();
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid request method";
    exit;
}
