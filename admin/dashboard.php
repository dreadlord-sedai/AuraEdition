<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserInfo($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] != "admin") {
    header("Location: /Projects/AuraEdition/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Dashboard</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminHeader.php'; ?>
</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Sidebar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminSidebar.php'; ?>
    <!-- Main Content Area -->
    <div class="ml-64 flex-1 flex flex-col">
        <!-- Navigation Bar -->
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminNavbar.php'; ?>
        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Page Title -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-yellow-400" style="font-family: 'Trajan Pro', serif;">Dashboard</h1>
                <a href="/Projects/AuraEdition/admin/pages/addProduct.php"
                    class="px-5 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-all shadow-md">
                    <i class="fas fa-plus mr-2"></i> Add New Vehicle
                </a>
            </div>
            <!-- Analytics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <!-- Total Listings Card -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-yellow-400/20 transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-lg font-semibold">Total Listings</p>
                            <p class="text-4xl font-bold text-white">
                                <?php
                                $sql = "SELECT COUNT(*) as total_listings FROM vehicles";
                                $result = $connection->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['total_listings'];
                                ?>
                            </p>
                        </div>
                        <div class="bg-gray-800 p-4 rounded-full">
                            <i class="fas fa-car text-yellow-400 text-3xl"></i>
                        </div>
                    </div>
                </div>
                <!-- Total Orders Card -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-yellow-400/20 transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-lg font-semibold">Total Orders</p>
                            <p class="text-4xl font-bold text-white">
                                <?php
                                $sql = "SELECT COUNT(*) as total_orders FROM orders";
                                $result = $connection->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['total_orders'];
                                ?>
                            </p>
                        </div>
                        <div class="bg-gray-800 p-4 rounded-full">
                            <i class="fas fa-receipt text-yellow-400 text-3xl"></i>
                        </div>
                    </div>
                </div>
                <!-- Total Users Card -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-yellow-400/20 transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-lg font-semibold">Total Users</p>
                            <p class="text-4xl font-bold text-white">
                                <?php
                                $sql = "SELECT COUNT(*) as total_users FROM users";
                                $result = $connection->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['total_users'];
                                ?>
                            </p>
                        </div>
                        <div class="bg-gray-800 p-4 rounded-full">
                            <i class="fas fa-users text-yellow-400 text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Orders & Sales Overview -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Recent Orders Table -->
                <div class="xl:col-span-2 bg-black border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-bold text-white mb-6">Recent Orders</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="px-5 py-3 text-sm font-semibold text-gray-400 uppercase">Order ID</th>
                                    <th class="px-5 py-3 text-sm font-semibold text-gray-400 uppercase">Customer</th>
                                    <th class="px-5 py-3 text-sm font-semibold text-gray-400 uppercase">Date</th>
                                    <th class="px-5 py-3 text-sm font-semibold text-gray-400 uppercase">Status</th>
                                    <th class="px-5 py-3 text-sm font-semibold text-gray-400 uppercase text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $orders = getRecentOrders($connection);
                                if ($orders) {
                                    foreach ($orders as $order):
                                        $user = getUserInfo($connection, $order['user_id']);
                                ?>
                                <tr class="border-b border-gray-800 hover:bg-gray-900 transition-colors">
                                    <td class="px-5 py-4 text-gray-200">#<?= htmlspecialchars($order['order_id']); ?></td>
                                    <td class="px-5 py-4 text-gray-200"><?= htmlspecialchars($user['email']); ?></td>
                                    <td class="px-5 py-4 text-gray-300"><?= date("M d, Y", strtotime($order['orderd_at'])); ?></td>
                                    <td class="px-5 py-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-300 border border-green-700"><?= htmlspecialchars($order['status']); ?></span>
                                    </td>
                                    <td class="px-5 py-4 text-right font-semibold text-white">$<?= number_format(htmlspecialchars($order['total_price']), 2); ?></td>
                                </tr>
                                <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Sales Overview Chart -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-bold text-white mb-4">Sales Overview</h2>
                    <div class="flex items-baseline mb-4">
                        <p class="text-3xl font-bold text-white">$1,250,000</p>
                        <span class="ml-2 text-green-400 font-semibold flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i>15%
                        </span>
                    </div>
                    <p class="text-gray-400 text-sm mb-6">Vs. last 12 months</p>
                    <div class="w-full h-48 bg-gray-900 rounded-lg p-2">
                        <svg viewBox="0 0 300 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <defs>
                                <linearGradient id="goldGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#FBBF24;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#F59E0B;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <polyline
                                fill="none"
                                stroke="url(#goldGradient)"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                points="0,60 30,40 60,50 90,20 120,40 150,10 180,50 210,30 240,60 270,20 300,60" />
                        </svg>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-2 px-1">
                        <span>Jan</span><span>Mar</span><span>May</span><span>Jul</span><span>Sep</span><span>Nov</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>