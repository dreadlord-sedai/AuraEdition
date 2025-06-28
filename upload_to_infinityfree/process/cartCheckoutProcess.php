<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

// 1. Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in, with a redirect back to the cart
    header("Location: /auth/login.php?redirect=cart");
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. Fetch all cart items from the database for the current user
$cart_items = getCartItemsByUserId($connection, $user_id);

// 3. If the cart is empty, just go back to the cart page.
if (empty($cart_items)) {
    header("Location: /pages/cart.php");
    exit;
}

// 4. Prepare the session for the checkout page by loading the DB items
$_SESSION['vehicles'] = [];
$total_price = 0;

foreach ($cart_items as $item) {
    // The checkout.php page expects an array with specific keys. Let's build it.
    $_SESSION['vehicles'][] = [
        'id' => $item['vehicle_id'],
        'title' => $item['title'],
        'price' => $item['price'],
        'quantity' => $item['quantity']
    ];
    $total_price += $item['price'] * $item['quantity'];
}

$_SESSION['total_price'] = $total_price;

// 5. Redirect to the checkout page, which will now be populated with the cart items
header("Location: /pages/checkout.php");
exit;
