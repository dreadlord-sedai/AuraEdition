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
    <title>AuraEdition | Products</title>
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
                    <h3 class="text-2xl font-semibold mb-4 text-light">Vehicles</h3>
                    <button><a href="/Projects/AuraEdition/admin/pages/addProduct.php"
                            class="btn btn-primary">Add Vehicle</a></button>
                </div>


                <!--Search section-->
                <div class="mb-8 flex flex-col items-center">
                    <!-- Search Bar Centered -->
                    <form method="GET" action="" class="w-full max-w-md text-center">
                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Search vehicles..."
                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </span>
                        </div>
                        <!-- Filters -->
                        <div class="flex flex-row gap-4 mt-4 w-full max-w-md mx-auto">
                            <!-- Status Filter -->
                            <select name="status" onchange="this.form.submit()" class="w-1/2 px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Statuses</option>
                                <option value="ACTIVE" <?= (($_GET['status'] ?? '') === 'ACTIVE') ? 'selected' : '' ?>>Active</option>
                                <option value="INACTIVE" <?= (($_GET['status'] ?? '') === 'INACTIVE') ? 'selected' : '' ?>>Inactive</option>
                            </select>
                            <!-- Price Filter -->
                            <select name="price" onchange="this.form.submit()" class="w-1/2 px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Sort by Price</option>
                                <option value="low" <?= (($_GET['price'] ?? '') === 'low') ? 'selected' : '' ?>>Low to High</option>
                                <option value="high" <?= (($_GET['price'] ?? '') === 'high') ? 'selected' : '' ?>>High to Low</option>
                            </select>
                        </div>
                    </form>
                </div>
                <!--Search section-->

                <!-- Product table -->
                <div class="overflow-x-auto mt-10">
                    <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">ID</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Name</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Status</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Price</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Stock</th>
                                <th class="px-4 py-2 text-left text-gray-300 font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search = $_GET['search'] ?? '';
                            $status = $_GET['status'] ?? '';
                            $price = $_GET['price'] ?? '';
                            $vehicles = getVehicles($connection, $search, $status, $price);
                            foreach ($vehicles as $vehicle):
                            ?>
                                <tr class="border-b border-gray-700">
                                    <td class="px-4 py-2 text-gray-100"><?= $vehicle['id']; ?></td>
                                    <td class="px-4 py-2 text-gray-100"><?= $vehicle['title']; ?></td>
                                    <td class="px-4 py-2">
                                        <span class= " <?php if ($vehicle['status'] === 'INACTIVE') {
                                                            echo 'bg-red-600';
                                                        } else if($vehicle['status'] === 'ACTIVE') {
                                                            echo 'bg-green-600';
                                                        } ?>
                                     text-white px-3 py-1 rounded-full text-xs"><?= $vehicle['status']; ?></span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-100">$<?= $vehicle['price']; ?></td>
                                    <td class="px-4 py-2 text-gray-100"><?= $vehicle['stock']; ?></td>
                                    <td class="px-4 py-2">
                                        <a href="/Projects/AuraEdition/admin/pages/EditProduct.php?id=<?= $vehicle['id'] ?>" class="text-blue-400 hover:underline mr-2">Edit</a>
                                        <a href="javascript:void(0)" onclick="deleteProduct(<?= $vehicle['id'] ?>); return false;" class="text-red-400 hover:underline">Delete</a>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Product table -->
            </div>
            <!-- Main Content -->
        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>