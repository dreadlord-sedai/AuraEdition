<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /Projects/AuraEdition/pages/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$data = fetchOrdersByUserId($connection, $user_id);

if (!$data || !isset($data['order'])) {
    echo "No recent order found.";
    exit;
}

$order = $data['order'];
$order_items = $data['order_items'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AuraEdition | Invoice</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>
</head>

<body>

    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Main Content -->
    <div class="flex container-md my-5 main-content justify-content-center">
        <!-- Invoice -->
        <div class="w-2/3 p-6">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Header with gray background -->
                <div class="bg-gray-800 text-white p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold">INVOICE</h1>
                            <p class="text-gray-300 text-sm mt-1">Order #<?php echo htmlspecialchars($order['order_id']); ?></p>
                        </div>
                        <div class="text-right text-sm">
                            <p class="text-gray-300">Date Issued</p>
                            <p class="font-semibold"><?php echo date("F j, Y", strtotime($order['orderd_at'])); ?></p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Customer & Shipping Info -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h2 class="text-gray-600 text-sm uppercase tracking-wider mb-2">Bill To</h2>
                            <div class="text-sm">
                                <p class="font-semibold"><?php echo htmlspecialchars($user['username'] ?? ''); ?></p>
                                <p class="text-gray-600"><?php echo htmlspecialchars($user['address'] ?? ''); ?></p>
                                <p class="text-gray-600"><?php echo htmlspecialchars($user['city'] ?? '') . ', ' . htmlspecialchars($user['state'] ?? '') . ' ' . htmlspecialchars($user['zip'] ?? ''); ?></p>
                                <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                                <p class="text-gray-600"><?php echo htmlspecialchars($user['phone'] ?? ''); ?></p>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-gray-600 text-sm uppercase tracking-wider mb-2">Ship To</h2>
                            <div class="text-sm">
                                <p class="font-semibold"><?php echo htmlspecialchars($user['username'] ?? ''); ?></p>
                                <p class="text-gray-600"><?php echo htmlspecialchars($user['address'] ?? ''); ?></p>
                                <p class="text-gray-600"><?php echo htmlspecialchars($user['city'] ?? '') . ', ' . htmlspecialchars($user['state'] ?? '') . ' ' . htmlspecialchars($user['zip'] ?? ''); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="mb-6">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left text-gray-600">Item</th>
                                    <th class="px-4 py-2 text-left text-gray-600">Price</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($order_items as $item): ?>
                                    <?php
                                    $vehicle = get_vehicle($item['vehicle_id'], $connection);
                                    ?>
                                    <tr>
                                        <td class="px-4 py-3"><?php echo htmlspecialchars($vehicle['title'] ?? 'Unknown Vehicle'); ?></td>
                                        <td class="px-4 py-3 text-right">$<?php echo number_format($item['price'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-end">
                            <div class="w-64">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Total</span>
                                    <span>$<?php echo number_format($order['total_price'], 2); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <p class="text-gray-600 uppercase tracking-wider mb-1">Payment Method</p>
                                <p class="font-semibold">Credit Card ending in 1234</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-600 uppercase tracking-wider mb-1">Payment Status</p>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Paid</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Invoice -->

    </div>
    <!-- Main Content -->

    <!-- Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>

</body>

</html>
