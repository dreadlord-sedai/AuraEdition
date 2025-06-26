<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

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

        // Generate PayHere payment parameters
        $order_id = uniqid('order_');
        $merchant_id = "1226262";
        $currency = "LKR";

        // Get user info for PayHere
        $user_id = $_SESSION['user_id'];
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

        // Return payment data to JS
        echo json_encode([
            "status" => "success",
            "payment" => [
                "sandbox" => true,
                "merchant_id" => $merchant_id,
                "return_url" => "http://localhost/Projects/AuraEdition/pages/checkout.php",
                "cancel_url" => "http://localhost/Projects/AuraEdition/pages/checkout.php",
                "notify_url" => "http://localhost/Projects/AuraEdition/process/payhereNotify.php",
                "order_id" => $order_id,
                "items" => "Vehicle Purchase",
                "amount" => number_format($amount, 2, '.', ''),
                "currency" => $currency,
                "first_name" => $user['fname'],
                "last_name" => $user['lname'],
                "email" => $user['email'],
                "address" => $user['address'],
                "city" => $user['city'],
                "country" => $user['country'],
            ]
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
