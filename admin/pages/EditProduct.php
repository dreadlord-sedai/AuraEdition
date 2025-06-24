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
    <title>AuraEdition | Edit Product</title>
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
                    <h3 class="text-2xl font-semibold mb-4 text-light">Edit Vehicle Product</h3>

                </div>

                <!-- Add Vehicle Product Form -->
                <form action="/Projects/AuraEdition/admin/actions/editProductProcess.php" method="POST" enctype="multipart/form-data"
                    class="bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-2xl mx-auto border border-gray-700">

                    <?php if (isset($_GET['error'])): ?>
                        <div class="bg-red-500 text-white p-4 rounded mb-4">
                            <p class="text-sm"><?php echo htmlspecialchars($_GET['error']); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['success'])): ?>
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            <p class="text-sm"><?php echo htmlspecialchars($_GET['success']); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Fetch product details from the database
                    $product_id = $_GET['id'];
                    $product = getProductInfo($connection, $product_id);

                    if (!$product) {
                        echo '<div class="bg-red-500 text-white p-4 rounded mb-4">Product not found.</div>';
                        exit;
                    }
                    ?>



                    <!-- Product Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-300 mb-1">Title</label>
                        <input type="text" name="title" id="title" required placeholder="<?= $title ?>"
                            value="<?= htmlspecialchars($product['title']) ?>"
                            class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 
                            focus:ring-blue-500 border border-gray-600">
                    </div>

                    <!-- Vehicle Make -->
                    <div class="mb-4">
                        <label for="make" class="block text-sm font-medium text-gray-300 mb-1">Make</label>
                        <select name="make" id="make" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 
                        focus:ring-blue-500 border border-gray-600">
                            <?php if (!empty($product)): ?>
                                <option value="<?= htmlspecialchars($product['make_id']) ?>" selected><?= htmlspecialchars($product['make_name']) ?></option>
                                <?php
                                $makes = getAllMakes($connection);
                                // Loop through makes and create options
                                foreach ($makes as $m):
                                ?>
                                    <option value="<?= htmlspecialchars($m['make_id']) ?>"><?= htmlspecialchars($m['make_name']) ?></option>
                                <?php
                                endforeach;
                                ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Vehicle Model -->
                    <div class="mb-4">
                        <label for="model" class="block text-sm font-medium text-gray-300 mb-1">Model</label>
                        <select name="model" id="model" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 
                        focus:ring-blue-500 border border-gray-600">
                            <?php if (!empty($product)): ?>
                                <option value="<?= htmlspecialchars($product['model_id']) ?>" selected><?= htmlspecialchars($product['model_name']) ?></option>
                                <?php
                                // Fetch models based on the selected make
                                $models = getModelsByMake($connection, $product['make_id']);
                                foreach ($models as $m):
                                    if ($m['model_id'] != $product['model_id']):
                                ?>
                                        <option value="<?= htmlspecialchars($m['model_id']) ?>"><?= htmlspecialchars($m['model_name']) ?></option>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Vehicle Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" required placeholder="<?= htmlspecialchars($product['description']) ?>"
                            class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 
                            focus:ring-blue-500 border border-gray-600"></textarea>
                    </div>

                    <!-- Product Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-300 mb-1">Price ($)</label>
                        <input type="number" name="price" id="price" step="0.01" required placeholder="Enter product price"
                            class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 
                            focus:ring-blue-500 border border-gray-600">
                    </div>

                    <!-- Product Stock -->
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-300 mb-1">Stock Quantity</label>
                        <input type="number" name="stock" id="stock" required placeholder="<?= htmlspecialchars($product['quantity']) ?>"
                            class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 
                            focus:ring-blue-500 border border-gray-600">
                    </div>

                    <!-- Product Status -->
                    <div class="mb-4">
                        <label for="product_status" class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                        <select name="product_status" id="product_status" required class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-600">
                            <?php if (!empty($product)): ?>
                                <option value="<?= htmlspecialchars($product['status']) ?>" selected><?= htmlspecialchars($product['status']) ?></option>
                                <?php
                                $statuses = ['ACTIVE', 'INACTIVE'];
                                foreach ($statuses as $status):
                                    if ($status != $product['status']):
                                ?>
                                        <option value="<?= htmlspecialchars($status) ?>"><?= htmlspecialchars(ucfirst($status)) ?></option>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Product Image -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-300 mb-1">Product Image</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg 
                        file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 border border-gray-600">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" name="update_product" value="update_product" class="btn btn-primary px-6 py-2">Update Vehicle Product</button>
                    </div>
                </form>
                <!--End Add Vehicle Product Form-->



            </div>
            <!-- Main Content -->

        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>


</body>

</html>