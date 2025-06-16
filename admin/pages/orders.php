<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUser($connection, $_SESSION['user_id']) : null;
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
    <title>AuraEdition | Orders</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminHeader.php'; ?>
</head>

<body class="bg-black">
    <div class="flex">
        <!-- Sidebar -->
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminSidebar.php'; ?>

        <!-- Main Content Area -->
        <div class="flex-1 min-h-screen flex flex-col">
            <!-- Navigation Bar -->
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminNavbar.php'; ?>
            <!-- Main Content -->
            <div class="p-8 flex flex-col">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-2xl font-semibold mb-4 text-light">Products</h3>
                </div>


                                <!-- Search section for Orders -->
                <div class="mb-8 flex flex-col items-center">
                    <form method="GET" action="" class="w-full max-w-md">
                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Search orders by customer, ID, or status..."
                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </span>
                        </div>
                    </form>
                    <!-- Filters -->
                    <div class="flex flex-row gap-4 mt-4 w-full max-w-md">
                        <!-- Status Filter -->
                        <select name="status" class="w-1/2 px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Statuses</option>
                            <option value="processing" <?= (($_GET['status'] ?? '') === 'processing') ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= (($_GET['status'] ?? '') === 'shipped') ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= (($_GET['status'] ?? '') === 'delivered') ? 'selected' : '' ?>>Delivered</option>
                        </select>
                        <!-- Date Filter -->
                        <input
                            type="date"
                            name="date"
                            class="w-1/2 px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?= htmlspecialchars($_GET['date'] ?? '') ?>"
                        >
                    </div>
                </div>

                                <!-- Orders Table -->
                <div class="overflow-x-auto mt-10">
                    <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Order ID</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Customer</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Order Date</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Status</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Total Amount</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example static rows, replace with PHP loop for dynamic data -->
                            <tr class="border-b border-gray-700">
                                <td class="px-4 py-2 text-gray-100">#1001</td>
                                <td class="px-4 py-2 text-gray-100">Ethan Harper</td>
                                <td class="px-4 py-2 text-gray-100">2024-07-26</td>
                                <td class="px-4 py-2">
                                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs">Shipped</span>
                                </td>
                                <td class="px-4 py-2 text-gray-100">$150,000</td>
                                <td class="px-4 py-2">
                                    <a href="#" class="text-blue-400 hover:underline">View Details</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 text-gray-100">#1002</td>
                                <td class="px-4 py-2 text-gray-100">Olivia Bennett</td>
                                <td class="px-4 py-2 text-gray-100">2024-07-25</td>
                                <td class="px-4 py-2">
                                    <span class="bg-yellow-600 text-white px-3 py-1 rounded-full text-xs">Processing</span>
                                </td>
                                <td class="px-4 py-2 text-gray-100">$200,000</td>
                                <td class="px-4 py-2">
                                    <a href="#" class="text-blue-400 hover:underline">View Details</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- Main Content -->

        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>