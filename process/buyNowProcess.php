<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1. Get Vehicle details from the database
        $vehicle_id = $_POST['id'];
        $vehicle = get_vehicle($vehicle_id, $connection);

        // 2. Initialize vehicles array in session if not set
        if (!isset($_SESSION['vehicles'])) {
            $_SESSION['vehicles'] = [];
        }

        // 3. Add vehicle to session array or increment quantity if already added
        $found = false;
        foreach ($_SESSION['vehicles'] as &$v) {
            if ($v['id'] == $vehicle['id']) {
                $v['quantity'] = isset($v['quantity']) ? $v['quantity'] + 1 : 2;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $vehicle['quantity'] = 1;
            $_SESSION['vehicles'][] = $vehicle;
        }
        unset($v);

        // 4. Calculate total price
        $total_price = 0;
        foreach ($_SESSION['vehicles'] as $v) {
            $qty = isset($v['quantity']) ? $v['quantity'] : 1;
            $total_price += $v['price'] * $qty;
        }
        $_SESSION['total_price'] = $total_price;

        echo "success";
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid request method";
    exit;
}
?>
