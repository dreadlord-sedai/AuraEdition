<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminFunctions.php';

$user = authorize_admin($connection);

// Fetch dynamic data
$total_revenue = getTotalRevenue($connection);
$total_listings = getTotalListings($connection);
$total_orders = getTotalOrders($connection);
$total_users = getTotalUsers($connection);
$sales_data = getSalesDataForChart($connection);
$recent_orders = getRecentOrders($connection);

$page_title = "Dashboard";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Dashboard</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminHeader.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-900 text-white" style="font-family: 'Lato', sans-serif;">
    <div class="flex min-h-screen">
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminSidebar.php'; ?>
        <div class="flex-1 flex flex-col">
            <?php 
                $breadcrumbs = ['Dashboard' => '/admin/dashboard.php'];
                include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminNavbar.php'; 
            ?>
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/content_header.php'; ?>

            <a href="/admin/pages/addProduct.php"
                class="absolute top-8 right-8 px-5 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-all shadow-md">
                <i class="fas fa-plus mr-2"></i> Add New Vehicle
            </a>

            <!-- Analytics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Total Revenue -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-semibold">Total Revenue</p>
                        <p class="text-2xl font-bold text-white">$<?= number_format($total_revenue, 2) ?></p>
                    </div>
                    <div class="text-yellow-400">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
                <!-- Total Listings -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-semibold">Total Listings</p>
                        <p class="text-2xl font-bold text-white"><?= $total_listings ?></p>
                    </div>
                    <div class="text-yellow-400">
                        <i class="fas fa-car fa-2x"></i>
                    </div>
                </div>
                <!-- Total Orders -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-semibold">Total Orders</p>
                        <p class="text-2xl font-bold text-white"><?= $total_orders ?></p>
                    </div>
                    <div class="text-yellow-400">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
                <!-- Total Users -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6 flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-semibold">Total Users</p>
                        <p class="text-2xl font-bold text-white"><?= $total_users ?></p>
                    </div>
                    <div class="text-yellow-400">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Sales Overview Chart -->
                <div class="xl:col-span-2 bg-black border border-gray-800 rounded-2xl p-6">
                    <h2 class="text-xl font-bold text-white mb-4">Sales Overview (Last 12 Months)</h2>
                    <div class="h-96">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-black border border-gray-800 rounded-2xl p-6">
                    <h2 class="text-xl font-bold text-white mb-4">Recent Orders</h2>
                    <div class="space-y-4">
                        <?php if (empty($recent_orders)): ?>
                            <p class="text-gray-400">No recent orders found.</p>
                        <?php else: ?>
                            <?php foreach ($recent_orders as $order): ?>
                                <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center mr-4">
                                            <i class="fas fa-user text-yellow-400"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-white"><?= htmlspecialchars($order['fname'] . ' ' . $order['lname']) ?></p>
                                            <p class="text-sm text-gray-400">Order #<?= htmlspecialchars($order['order_id']) ?></p>
                                        </div>
                                    </div>
                                    <span class="font-bold text-yellow-400">$<?= number_format($order['total_price'], 2) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/content_footer.php'; ?>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
