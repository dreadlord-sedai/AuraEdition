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
    <title>AuraEdition | Users</title>
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
                    <h3 class="text-2xl font-semibold mb-4 text-light">Users</h3>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto mt-10">
                    <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Order ID</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Customer</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Order Date</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Status</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search = $_GET['search'] ?? '';
                            $status = $_GET['status'] ?? '';
                            $date = $_GET['date'] ?? '';
                            $orders = getAllOrders($connection);
                            foreach ($orders as $order):
                                $user = getUserInfo($connection, $order['user_id']);
                            ?>
                                <tr class="border-b border-gray-700">
                                    <td class="px-4 py-2 text-gray-100"><?= $order['order_id']; ?></td>
                                    <td class="px-4 py-2 text-gray-100"><?= $user['fname'] . ' ' . $user['lname']; ?></td>
                                    <td class="px-4 py-2 text-gray-100"><?= $order['orderd_at']; ?></td>
                                    <td class="px-4 py-2">
                                        <span class="
                                    <?php
                                    if ($order['status'] === 'pending') {
                                        echo 'bg-yellow-600';
                                    } else if ($order['status'] === 'shipped') {
                                        echo 'bg-green-600';
                                    } else if ($order['status'] === 'delivered') {
                                        echo 'bg-blue-600';
                                    } else {
                                        echo 'bg-gray-600';
                                    }
                                    ?>
                                     text-white px-3 py-1 rounded-full text-xs"><?= $order['status']; ?></span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-100">$<?= $order['total_price']; ?></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Users Table -->

            </div>
            <!-- Main Content -->

        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>