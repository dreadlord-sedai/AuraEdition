<?php
header('Content-Type: application/json');
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_SESSION['vehicles']) || count($_SESSION['vehicles']) === 0) {
            echo json_encode(["status" => "error", "message" => "Cart is empty"]);
            exit;
        }
        if (!isset($_SESSION['user_id']) || !hasUserAddresses($connection, $_SESSION['user_id'])) {
            echo json_encode(["status" => "error", "message" => "User has not added addresses"]);
            exit;
        }

        $vehicles = $_SESSION['vehicles'];
        $total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;
        $amount = $total_price;
        if ($amount <= 0) {
            echo json_encode(["status" => "error", "message" => "Total price is zero or negative"]);
            exit;
        }

        // Insert order into orders table
        $user_id = $_SESSION['user_id'];
        $order_stmt = $connection->prepare("INSERT INTO orders (user_id, total_price, orderd_at, status) VALUES (?, ?, NOW(), 'pending')");
        $order_stmt->bind_param("id", $user_id, $amount);
        $order_stmt->execute();
        $order_id = $connection->insert_id;
        $order_stmt->close();

        // Insert each item into order_items table
        $item_stmt = $connection->prepare("INSERT INTO order_items (order_id, vehicle_id, price, quantity) VALUES (?, ?, ?, ?)");
        foreach ($vehicles as $vehicle) {
            $item_stmt->bind_param("iidi", $order_id, $vehicle['id'], $vehicle['price'], $vehicle['quantity']);
            $item_stmt->execute();
        }
        $item_stmt->close();

        // Optionally, clear the cart after purchase
        unset($_SESSION['vehicles']);
        unset($_SESSION['total_price']);
        clearCart($connection, $user_id);

        // Generate PayHere payment parameters
        $order_code = uniqid('order_');
        $merchant_id = "1224621"; // Use your actual merchant ID
        $currency = "LKR";

        // Get user info for PayHere
        $user = getUserWithAddress($connection, $user_id);

        // Defensive check: Make sure $user is valid and has all required fields
        if (
            !$user ||
            empty($user['fname']) ||
            empty($user['lname']) ||
            empty($user['email']) ||
            empty($user['address']) ||
            empty($user['city']) ||
            empty($user['country'])
        ) {
            echo json_encode(["status" => "error", "message" => "User address details are incomplete."]);
            exit;
        }

        $merchant_secret = 'MjgxNzA1MDMzMTk3NzczNDYzMzMyODc4MjcxODUyMjkwNDE2Nzgz'; // Replace with your actual merchant secret for your domain/app

        $hash = strtoupper(
            md5(
                $merchant_id .
                $order_code .
                number_format($amount, 2, '.', '') .
                $currency .
                strtoupper(md5($merchant_secret))
            )
        );

        // Build payment array (NO hash)
        $payment = [
            "sandbox" => true,
            "merchant_id" => $merchant_id,
            "return_url" => "http://localhost/pages/checkout.php",
            "cancel_url" => "http://localhost/pages/checkout.php",
            "notify_url" => "http://localhost/process/payhereNotify.php",
            "order_id" => $order_code,
            "items" => "Vehicle Purchase",
            "amount" => number_format($amount, 2, '.', ''),
            "currency" => $currency,
            "first_name" => $user['fname'],
            "last_name" => $user['lname'],
            "email" => $user['email'],
            "address" => $user['address'],
            "city" => $user['city'],
            "country" => $user['country'],
            "hash" => $hash // <-- Required for PayHere JS SDK
        ];

        echo json_encode([
            "status" => "success",
            "payment" => $payment
        ]);
        exit;
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
