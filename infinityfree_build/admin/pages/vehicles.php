<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

$user = authorize_admin($connection);

// Get all vehicles
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$price_sort = $_GET['price'] ?? ''; // Renamed to avoid conflict
$vehicles = getVehicles($connection, $search, $status, $price_sort);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Manage Vehicles</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminHeader.php'; ?>
</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Sidebar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminSidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="ml-64 flex-1 flex flex-col">
        <!-- Navigation Bar -->
        <?php 
            $breadcrumbs = ['Vehicles' => '/Projects/AuraEdition/admin/pages/vehicles.php'];
            include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminNavbar.php'; 
        ?>
        
        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Page Title -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-yellow-400" style="font-family: 'Trajan Pro', serif;">Manage Vehicles</h1>
                <a href="/Projects/AuraEdition/admin/pages/addProduct.php"
                    class="px-5 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-all shadow-md flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add New Vehicle
                </a>
            </div>

            <!-- Search and Filters -->
            <div class="bg-black border border-gray-800 rounded-2xl p-6 mb-8">
                <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-semibold text-gray-400 mb-2">Search by Name</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-3.5 text-gray-500"></i>
                            <input type="text" name="search" id="search"
                                class="w-full pl-12 pr-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition"
                                placeholder="e.g., Phantom VIII"
                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                    </div>
                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-400 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                            <option value="">All Statuses</option>
                            <option value="ACTIVE" <?= (($_GET['status'] ?? '') === 'ACTIVE') ? 'selected' : '' ?>>Active</option>
                            <option value="INACTIVE" <?= (($_GET['status'] ?? '') === 'INACTIVE') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all shadow-md">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Vehicles Table -->
            <div class="bg-black border border-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-700 bg-gray-900/50">
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">ID</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Name</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Price</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Stock</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($vehicles as $vehicle):
                            ?>
                            <tr class="border-b border-gray-800 hover:bg-gray-900 transition-colors">
                                <td class="px-6 py-4 text-gray-200 font-mono">#<?= htmlspecialchars($vehicle['id']); ?></td>
                                <td class="px-6 py-4 text-white font-semibold"><?= htmlspecialchars($vehicle['title']); ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $vehicle['status'] === 'ACTIVE' ? 'bg-green-900 text-green-300 border border-green-700' : 'bg-red-900 text-red-300 border border-red-700' ?>">
                                        <?= htmlspecialchars($vehicle['status']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-200">$<?= number_format(htmlspecialchars($vehicle['price']), 2); ?></td>
                                <td class="px-6 py-4 text-gray-200"><?= htmlspecialchars($vehicle['stock']); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <a href="/Projects/AuraEdition/admin/pages/EditProduct.php?id=<?= $vehicle['id'] ?>" class="text-yellow-400 hover:text-yellow-300 font-semibold mr-4">Edit</a>
                                    <a href="javascript:void(0)" onclick="deleteProduct(<?= $vehicle['id'] ?>); return false;" class="text-red-500 hover:text-red-400 font-semibold">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script>
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this vehicle?')) {
                window.location.href = '/Projects/AuraEdition/admin/process/handleVehicle.php?action=delete&id=' + id;
            }
        }
    </script>
</body>
</html>