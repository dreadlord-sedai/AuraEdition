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

        // Check if user has added addresses
        if (!isset($_SESSION['user_id']) || !hasUserAddresses($connection, $_SESSION['user_id'])) {
            echo "Error: User has not added addresses";
            exit;
        }

        



        // 1. Get cart items from session
        $vehicles = $_SESSION['vehicles'];
        $total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;
        $amount = $total_price;
        if ($amount <= 0) {
            echo "Error: Total price is zero or negative";
            exit;
        }

        // 2. Process the payment
        // For this example, we simulate payment success
        // $payment_success = true;

        // if (!$payment_success) {
        //     echo "Error: Payment failed";
        //     exit;
        // }

        $order_id = uniqid('order_'); // Generate a unique order ID

        // Generate order ID and amount
        $merchant_id = "1226262";
        $merchant_secret = "MTI5OTQ4NjUwNjI0MDgzNjM1MDgxMTkxMDQyOTAwNDg4Mjk5NDgy";
        $currency = "LKR";

        $hash = strtoupper(
            md5(
                $merchant_id .
                $order_id .
                number_format($amount, 2, '.', '') .
                $currency .
                strtoupper(md5($merchant_secret))
            )
        );

        // 3. Create order record in database
        // Assuming you have an orders table and order_items table
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if (!$user_id) {
            echo "Error: User not logged in";
            exit;
        }

        $connection->begin_transaction();
        
        // Insert order record
        $stmt = $connection->prepare("INSERT INTO orders (user_id, total_price, orderd_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $user_id, $total_price);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Insert order items
        $stmt_item = $connection->prepare("INSERT INTO order_items (order_id, vehicle_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($vehicles as $vehicle) {
            $stmt_item->bind_param("iiid", $order_id, $vehicle['id'], $vehicle['quantity'], $vehicle['price']);
            $stmt_item->execute();
        }

        // Update vehicle stock and set status to INACTIVE if stock reaches 0
        foreach ($vehicles as $vehicle) {
            $stmt_item = $connection->prepare("UPDATE vehicles SET stock = stock - ? WHERE id = ?");
            $stmt_item->bind_param("ii", $vehicle['quantity'], $vehicle['id']);
            $stmt_item->execute();

            // Check if stock is 0 and update status
            $check_stock_stmt = $connection->prepare("SELECT stock FROM vehicles WHERE id = ?");
            $check_stock_stmt->bind_param("i", $vehicle['id']);
            $check_stock_stmt->execute();
            $result = $check_stock_stmt->get_result();
            $row = $result->fetch_assoc();
            $check_stock_stmt->close();

            if ($row && $row['stock'] <= 0) {
                $update_status_stmt = $connection->prepare("UPDATE vehicles SET status = 'INACTIVE' WHERE id = ?");
                $update_status_stmt->bind_param("i", $vehicle['id']);
                $update_status_stmt->execute();
                $update_status_stmt->close();
            }
        }
        $stmt_item->close();

        $connection->commit();

        // 4. Clear the  cart
        unset($_SESSION['vehicles']);
        unset($_SESSION['total_price']);

        clearCart($connection, $user_id);

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
