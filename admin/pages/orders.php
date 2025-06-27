<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserInfo($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] != "admin") {
    header("Location: /Projects/AuraEdition/index.php");
    exit;
}

// Pagination logic
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$offset = ($page - 1) * $items_per_page;

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$total_orders = countAllOrders($connection, $search, $status);
$total_pages = ceil($total_orders / $items_per_page);

$orders = getAllOrders($connection, $search, $status, $items_per_page, $offset);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Manage Orders</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminHeader.php'; ?>
</head>

<body class="bg-gray-900 text-gray-100">
        <!-- Sidebar -->
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminSidebar.php'; ?>

        <!-- Main Content Area -->
    <div class="ml-64 flex-1 flex flex-col">
            <!-- Navigation Bar -->
        <?php 
            $breadcrumbs = ['Orders' => '/Projects/AuraEdition/admin/pages/orders.php'];
            include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminNavbar.php'; 
        ?>
        
            <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Page Title -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-yellow-400" style="font-family: 'Trajan Pro', serif;">Manage Orders</h1>
                </div>

            <!-- Search and Filters -->
            <div class="bg-black border border-gray-800 rounded-2xl p-6 mb-8">
                <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-semibold text-gray-400 mb-2">Search Orders</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-3.5 text-gray-500"></i>
                            <input type="text" name="search" id="search"
                                class="w-full pl-12 pr-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition"
                                placeholder="Search by customer, ID, status..."
                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-400 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                            <option value="">All Statuses</option>
                            <option value="pending" <?= (($_GET['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
                            <option value="processing" <?= (($_GET['status'] ?? '') === 'processing') ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= (($_GET['status'] ?? '') === 'shipped') ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= (($_GET['status'] ?? '') === 'delivered') ? 'selected' : '' ?>>Delivered</option>
                            <option value="cancelled" <?= (($_GET['status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all shadow-md">
                            Filter Orders
                        </button>
                    </div>
                </form>
                </div>

                <!-- Orders Table -->
            <div class="bg-black border border-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-700 bg-gray-900/50">
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Order ID</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Customer</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Date</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase text-right">Total</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orders as $order):
                                $user = getUserInfo($connection, $order['user_id']);
                                $status_classes = [
                                    'pending' => 'bg-yellow-900 text-yellow-300 border-yellow-700',
                                    'processing' => 'bg-blue-900 text-blue-300 border-blue-700',
                                    'shipped' => 'bg-indigo-900 text-indigo-300 border-indigo-700',
                                    'delivered' => 'bg-green-900 text-green-300 border-green-700',
                                    'cancelled' => 'bg-red-900 text-red-300 border-red-700',
                                ];
                                $status_class = $status_classes[$order['status']] ?? 'bg-gray-700 text-gray-200 border-gray-600';
                            ?>
                            <tr class="border-b border-gray-800 hover:bg-gray-900 transition-colors">
                                <td class="px-6 py-4 text-gray-200 font-mono">#<?= htmlspecialchars($order['order_id']); ?></td>
                                <td class="px-6 py-4 text-white font-semibold"><?= htmlspecialchars($user['fname'] . ' ' . $user['lname']); ?></td>
                                <td class="px-6 py-4 text-gray-300"><?= date("M d, Y", strtotime($order['orderd_at'])); ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full border <?= $status_class ?>">
                                        <?= htmlspecialchars(ucfirst($order['status'])); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-white">$<?= number_format(htmlspecialchars($order['total_price']), 2); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <a href="#" class="text-yellow-400 hover:text-yellow-300 font-semibold">View Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="flex justify-between items-center mt-6 px-6 py-4 bg-black border-t border-gray-800">
                    <div class="text-sm text-gray-400">
                        Showing <span class="font-semibold text-white"><?= $offset + 1 ?></span> to <span class="font-semibold text-white"><?= min($offset + $items_per_page, $total_orders) ?></span> of <span class="font-semibold text-white"><?= $total_orders ?></span> results
                    </div>
                    <div class="flex items-center">
                        <?php
                        $query_params = http_build_query(array_filter(['search' => $search, 'status' => $status]));
                        $base_url = "/Projects/AuraEdition/admin/pages/orders.php?" . $query_params;

                        // Previous button
                        if ($page > 1) {
                            echo '<a href="' . $base_url . '&page=' . ($page - 1) . '" class="px-4 py-2 mx-1 bg-gray-800 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">Previous</a>';
                        } else {
                            echo '<span class="px-4 py-2 mx-1 bg-gray-800 text-gray-500 rounded-lg cursor-not-allowed">Previous</span>';
                        }

                        // Page numbers
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo '<span class="px-4 py-2 mx-1 bg-yellow-400 text-black font-semibold rounded-lg">' . $i . '</span>';
                            } else {
                                echo '<a href="' . $base_url . '&page=' . $i . '" class="px-4 py-2 mx-1 bg-gray-800 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">' . $i . '</a>';
                            }
                        }

                        // Next button
                        if ($page < $total_pages) {
                            echo '<a href="' . $base_url . '&page=' . ($page + 1) . '" class="px-4 py-2 mx-1 bg-gray-800 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">Next</a>';
                        } else {
                            echo '<span class="px-4 py-2 mx-1 bg-gray-800 text-gray-500 rounded-lg cursor-not-allowed">Next</span>';
                        }
                        ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>