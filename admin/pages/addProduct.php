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
    <title>AuraEdition | Add Product</title>
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
                    <h3 class="text-2xl font-semibold mb-4 text-light">Add New Vehicle Product</h3>
                    
                </div>

                <!-- Add Vehicle Product Form -->
                <form action="/Projects/AuraEdition/admin/actions/handleAddProduct.php" method="POST" enctype="multipart/form-data" 
                class="bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-2xl mx-auto border border-gray-700">
                    

                    <!-- Product Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-300 mb-1">Product Title</label>
                        <input type="text" name="title" id="title" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600">
                    </div>

                    <!-- Vehicle Make -->
                    <div class="mb-4">
                        <label for="make" class="block text-sm font-medium text-gray-300 mb-1">Make</label>
                        <select name="make" id="make" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600">
                            <option value="">-- Select Make --</option>
                            <option value="Toyota">Toyota</option>
                            <option value="Honda">Honda</option>
                            <option value="Ford">Ford</option>
                            <option value="BMW">BMW</option>
                            <!-- Add more makes as needed, or populate dynamically -->
                        </select>
                    </div>

                    <!-- Vehicle Model -->
                    <div class="mb-4">
                        <label for="model" class="block text-sm font-medium text-gray-300 mb-1">Model</label>
                        <select name="model" id="model" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600">
                            <option value="">-- Select Model --</option>
                            <option value="Camry">Camry (Toyota)</option>
                            <option value="Civic">Civic (Honda)</option>
                            <option value="F-150">F-150 (Ford)</option>
                            <!-- Add more models as needed, ideally populated based on selected make -->
                        </select>
                    </div>

                    <!-- Vehicle Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600"></textarea>
                    </div>

                    <!-- Product Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-300 mb-1">Price ($)</label>
                        <input type="number" name="price" id="price" step="0.01" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600">
                    </div>

                    <!-- Product Stock -->
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-300 mb-1">Stock Quantity</label>
                        <input type="number" name="stock" id="stock" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600">
                    </div>

                    <!-- Product Status -->
                    <div class="mb-4">
                        <label for="product_status" class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                        <select name="product_status" id="product_status" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Product Image -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-300 mb-1">Product Image</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 border border-gray-600">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary px-6 py-2">Add Vehicle Product</button>
                    </div>
                </form>
                <!--End Add Vehicle Product Form-->



            </div>
            <!-- Main Content -->

        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>