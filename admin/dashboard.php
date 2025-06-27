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

// Fetch dynamic data
$total_revenue = getTotalRevenue($connection);
$total_listings = getTotalListings($connection);
$total_orders = getTotalOrders($connection);
$total_users = getTotalUsers($connection);
$sales_data = getSalesDataForChart($connection);
$recent_orders = getRecentOrders($connection);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Dashboard</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminHeader.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Sidebar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminSidebar.php'; ?>
    <!-- Main Content Area -->
    <div class="ml-64 flex-1 flex flex-col">
        <!-- Navigation Bar -->
        <?php 
            $breadcrumbs = ['Dashboard' => '/Projects/AuraEdition/admin/dashboard.php'];
            include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminNavbar.php'; 
        ?>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div class="bg-black border border-gray-800 rounded-2xl p-6 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-lg font-semibold">Total Revenue</p>
                        <p class="text-4xl font-bold text-white">$<?= number_format($total_revenue, 2) ?></p>
                    </div>
                    <i class="fas fa-dollar-sign text-yellow-400 text-4xl opacity-50"></i>
                </div>
                <div class="bg-black border border-gray-800 rounded-2xl p-6 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-lg font-semibold">Total Listings</p>
                        <p class="text-4xl font-bold text-white"><?= $total_listings ?></p>
                    </div>
                    <i class="fas fa-car text-yellow-400 text-4xl opacity-50"></i>
                </div>
                <div class="bg-black border border-gray-800 rounded-2xl p-6 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-lg font-semibold">Total Orders</p>
                        <p class="text-4xl font-bold text-white"><?= $total_orders ?></p>
                    </div>
                    <i class="fas fa-receipt text-yellow-400 text-4xl opacity-50"></i>
                </div>
                <div class="bg-black border border-gray-800 rounded-2xl p-6 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-lg font-semibold">Total Users</p>
                        <p class="text-4xl font-bold text-white"><?= $total_users ?></p>
                    </div>
                    <i class="fas fa-users text-yellow-400 text-4xl opacity-50"></i>
                </div>
            </div>
            <!-- Recent Orders & Sales Overview -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Recent Orders Table -->
                <div class="xl:col-span-2 bg-black border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-bold text-white mb-6">Sales Overview (Last 12 Months)</h2>
                    <div style="height: 350px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
                <!-- Sales Overview Chart -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-bold text-white mb-6">Recent Orders</h2>
                    <div class="space-y-4">
                        <?php foreach($recent_orders as $order): ?>
                        <div class="flex items-center justify-between pb-4 border-b border-gray-800 last:border-b-0">
                            <div>
                                <p class="font-semibold text-white"><?= htmlspecialchars($order['fname'] . ' ' . $order['lname']) ?></p>
                                <p class="text-sm text-gray-400">Order #<?= htmlspecialchars($order['order_id']) ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-yellow-400">$<?= number_format($order['total_price'], 2) ?></p>
                                <p class="text-sm text-gray-500"><?= date("M d, Y", strtotime($order['orderd_at'])) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('salesChart').getContext('2d');

    const salesLabels = <?= json_encode($sales_data['labels']) ?>;
    const salesValues = <?= json_encode($sales_data['data']) ?>;

    const gradient = ctx.createLinearGradient(0, 0, 0, 350);
    gradient.addColorStop(0, 'rgba(251, 191, 36, 0.6)');
    gradient.addColorStop(1, 'rgba(251, 191, 36, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Monthly Sales',
                data: salesValues,
                borderColor: '#FBBF24',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#FBBF24',
                pointBorderColor: '#111827',
                pointHoverBackgroundColor: '#FFFFFF',
                pointHoverBorderColor: '#FBBF24',
                pointRadius: 5,
                pointHoverRadius: 8,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                    ticks: { 
                        color: '#9CA3AF',
                        callback: function(value) { return '$' + Math.round(value / 1000) + 'k'; }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF' }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleColor: '#FBBF24',
                    bodyColor: '#E5E7EB',
                    borderColor: '#FBBF24',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Sales: $' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>