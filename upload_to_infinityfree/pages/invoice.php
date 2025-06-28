<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /pages/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$data = fetchOrdersByUserId($connection, $user_id);

if (!$data || !isset($data['order'])) {
    echo "No recent order found.";
    exit;
}

$order = $data['order'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AuraEdition | Invoice</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
</head>

<body class="bg-black min-h-screen text-white">
    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center py-10 bg-black">
      <div class="bg-gray-900 rounded-2xl shadow-2xl max-w-2xl w-full p-10 border border-yellow-400/20">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 border-b border-yellow-400/20 pb-6">
          <div>
            <h1 class="text-3xl font-bold text-yellow-400 font-serif" style="font-family: 'Trajan Pro', serif;">AuraEdition</h1>
            <p class="text-gray-400 text-sm mt-1">123 Main St, City, Country</p>
          </div>
          <div class="text-right">
            <h2 class="text-xl font-bold text-yellow-400 tracking-wider">INVOICE</h2>
            <p class="text-gray-400">#<?= htmlspecialchars($order['order_id']) ?></p>
            <p class="text-gray-400"><?php echo date('F j, Y', strtotime($order['orderd_at'])); ?></p>
          </div>
        </div>
        <!-- Customer & Order Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <div>
            <h3 class="font-semibold text-gray-400 mb-1 uppercase tracking-wider">Billed To:</h3>
            <?php $user = getUserWithAddress($connection, $user_id); ?>
            <p class="text-lg font-semibold text-white"><?php echo htmlspecialchars($user['fname'] ?? '') . ' ' . htmlspecialchars($user['lname'] ?? ''); ?></p>
            <p class="text-gray-400"><?php echo htmlspecialchars($user['address'] ?? ''); ?></p>
            <p class="text-gray-400"><?php echo htmlspecialchars($user['city'] ?? '') . ', ' . htmlspecialchars($user['state'] ?? ''); ?></p>
            <p class="text-gray-400 mt-2"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
          </div>
          <div>
            <h3 class="font-semibold text-gray-400 mb-1 uppercase tracking-wider">Order Details:</h3>
            <p class="text-white">Order #: <span class="text-yellow-400 font-semibold"><?= htmlspecialchars($order['order_id']) ?></span></p>
            <p class="text-gray-400">Date: <?php echo date('F j, Y', strtotime($order['orderd_at'])); ?></p>
            <p class="text-gray-400">Status: <span class="font-semibold text-green-400">Paid</span></p>
          </div>
        </div>
        <!-- Items Table -->
        <div class="overflow-x-auto mb-8">
          <table class="min-w-full text-left border border-yellow-400/10 rounded-lg bg-gray-800">
            <thead>
              <tr class="bg-yellow-400/10">
                <th class="py-3 px-4 font-semibold text-yellow-400">Item</th>
                <th class="py-3 px-4 font-semibold text-yellow-400 text-right">Price</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $order_items = getOrderItemsByOrderId($connection, $order['order_id']);
              foreach ($order_items as $item):
                $vehicle = get_vehicle($item['vehicle_id'], $connection);
              ?>
                <tr class="border-b border-yellow-400/5 last:border-b-0">
                  <td class="py-3 px-4 text-white"><?= htmlspecialchars($vehicle['title'] ?? 'Unknown Vehicle'); ?></td>
                  <td class="py-3 px-4 text-yellow-400 text-right font-semibold">$<?= number_format($item['price'], 2); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- Totals -->
        <div class="flex justify-end mb-8">
          <div class="w-full max-w-xs">
            <div class="flex justify-between py-2">
              <span class="text-gray-400">Total</span>
              <span class="text-2xl text-yellow-400 font-bold">$<?php echo number_format($order['total_price'], 2); ?></span>
            </div>
          </div>
        </div>
        <!-- Payment Info -->
        <div class="border-t border-yellow-400/10 pt-6">
          <div class="flex justify-between items-center text-sm">
            <div>
              <p class="text-gray-400 uppercase tracking-wider mb-1">Payment Method</p>
              <p class="font-semibold text-white">Credit Card ending in 1234</p>
            </div>
            <div class="text-right">
              <p class="text-gray-400">Thank you for your purchase!</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Main Content -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
