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
    <title>AuraEdition | Dashboard</title>
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
                <!-- Dashboard content here -->
                <!--Analytics-->
                <div class="flex flex-row justify-content-center gap-5 align-items-center">
                    <div class=" flex flex-col card-1 bg-gray-400 px-5 py-3 rounded-lg text-start">
                        <p>Total products</p>
                        <b>
                            <p>150</p>
                        </b>
                    </div>

                    <div class="card-1 bg-gray-400 px-5 py-3 rounded-lg justify-content-center align-items-center">
                        <p>Total products</p>
                        <b>
                            <p>150</p>
                        </b>
                    </div>

                    <div class="card-1 bg-gray-400 px-5 py-3 rounded-lg justify-content-center align-items-center">
                        <p>Total products</p>
                        <b>
                            <p>150</p>
                        </b>
                    </div>
                </div>
                <!--Analytics-->

                <!--Recent orders-->
                <div class="mt-10">
                    <h2 class="text-lg font-semibold mb-4 text-light">Recent Orders</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-300 font-medium">Order ID</th>
                                    <th class="px-4 py-2 text-left text-gray-300 font-medium">Customer</th>
                                    <th class="px-4 py-2 text-left text-gray-300 font-medium">Date</th>
                                    <th class="px-4 py-2 text-left text-gray-300 font-medium">Status</th>
                                    <th class="px-4 py-2 text-left text-gray-300 font-medium">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-700">
                                    <td class="px-4 py-2 text-gray-100">#1001</td>
                                    <td class="px-4 py-2 text-gray-100">Ethan Harper</td>
                                    <td class="px-4 py-2 text-gray-100">2024-07-26</td>
                                    <td class="px-4 py-2">
                                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs">Shipped</span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-100">$150,000</td>
                                </tr>
                                <tr class="border-b border-gray-700">
                                    <td class="px-4 py-2 text-gray-100">#1002</td>
                                    <td class="px-4 py-2 text-gray-100">Olivia Bennett</td>
                                    <td class="px-4 py-2 text-gray-100">2024-07-25</td>
                                    <td class="px-4 py-2">
                                        <span class="bg-yellow-600 text-white px-3 py-1 rounded-full text-xs">Processing</span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-100">$200,000</td>
                                </tr>
                                <tr class="border-b border-gray-700">
                                    <td class="px-4 py-2 text-gray-100">#1003</td>
                                    <td class="px-4 py-2 text-gray-100">Liam Carter</td>
                                    <td class="px-4 py-2 text-gray-100">2024-07-24</td>
                                    <td class="px-4 py-2">
                                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs">Delivered</span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-100">$250,000</td>
                                </tr>
                                <tr class="border-b border-gray-700">
                                    <td class="px-4 py-2 text-gray-100">#1004</td>
                                    <td class="px-4 py-2 text-gray-100">Sophia Evans</td>
                                    <td class="px-4 py-2 text-gray-100">2024-07-23</td>
                                    <td class="px-4 py-2">
                                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs">Shipped</span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-100">$300,000</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-gray-100">#1005</td>
                                    <td class="px-4 py-2 text-gray-100">Noah Foster</td>
                                    <td class="px-4 py-2 text-gray-100">2024-07-22</td>
                                    <td class="px-4 py-2">
                                        <span class="bg-yellow-600 text-white px-3 py-1 rounded-full text-xs">Processing</span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-100">$350,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>