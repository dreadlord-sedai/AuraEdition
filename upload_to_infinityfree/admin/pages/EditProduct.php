<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminFunctions.php';

$user = authorize_admin($connection);

// Fetch product details
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = getProductInfo($connection, $product_id);

if (!$product) {
    set_flash('error', 'Product not found.');
    header("Location: /admin/pages/vehicles.php");
    exit;
}

$makes = getAllMakes($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Edit Vehicle</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminHeader.php'; ?>
</head>

<body class="bg-gray-900 text-gray-100">
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminSidebar.php'; ?>
    <div class="ml-64 flex-1 flex flex-col">
        <?php 
            $breadcrumbs = [
                'Vehicles' => '/admin/pages/vehicles.php',
                'Edit Vehicle' => '#'
            ];
            include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminNavbar.php'; 
        ?>
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-yellow-400" style="font-family: 'Trajan Pro', serif;">Edit Vehicle</h1>
                </div>

            <?php if ($msg = get_flash('success')): ?>
                <div class="mb-6 p-4 bg-green-900/80 border border-green-700 text-green-300 rounded-lg shadow-lg"><?= htmlspecialchars($msg) ?></div>
            <?php elseif ($msg = get_flash('error')): ?>
                <div class="mb-6 p-4 bg-red-900/80 border border-red-700 text-red-300 rounded-lg shadow-lg"><?= htmlspecialchars($msg) ?></div>
                    <?php endif; ?>

            <div class="bg-black border border-gray-800 rounded-2xl p-8 shadow-lg">
                <form action="/admin/process/editProductProcess.php" method="POST" enctype="multipart/form-data" class="space-y-8">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-400 mb-2">Vehicle Title</label>
                                <input type="text" name="title" id="title" required value="<?= htmlspecialchars($product['title']) ?>" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                    </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="make" class="block text-sm font-semibold text-gray-400 mb-2">Make</label>
                                    <select name="make" id="make" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                                        <option value="">Select Make</option>
                                        <?php foreach ($makes as $m): ?>
                                            <option value="<?= htmlspecialchars($m['make_id']) ?>" <?= $m['make_id'] == $product['make_id'] ? 'selected' : '' ?>><?= htmlspecialchars($m['make_name']) ?></option>
                                        <?php endforeach; ?>
                        </select>
                    </div>
                                <div>
                                    <label for="model" class="block text-sm font-semibold text-gray-400 mb-2">Model</label>
                                    <select name="model" id="model" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400" disabled>
                                        <option value="">Select Make First</option>
                        </select>
                    </div>
                    </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-400 mb-2">Description</label>
                                <textarea name="description" id="description" rows="6" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400"><?= htmlspecialchars($product['description']) ?></textarea>
                            </div>
                    </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="price" class="block text-sm font-semibold text-gray-400 mb-2">Price ($)</label>
                                    <input type="number" name="price" id="price" step="0.01" required value="<?= htmlspecialchars($product['price']) ?>" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                                </div>
                                <div>
                                    <label for="stock" class="block text-sm font-semibold text-gray-400 mb-2">Stock</label>
                                    <input type="number" name="stock" id="stock" required value="<?= htmlspecialchars($product['stock']) ?>" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                                </div>
                    </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-400 mb-2">Status</label>
                                <select name="status" id="status" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                                    <option value="Available" <?= $product['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                                    <option value="Sold Out" <?= $product['status'] == 'Sold Out' ? 'selected' : '' ?>>Sold Out</option>
                        </select>
                    </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-400 mb-2">Update Image (Optional)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-700 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                        <div class="flex text-sm text-gray-500">
                                            <label for="image" class="relative cursor-pointer bg-gray-800 rounded-md font-medium text-yellow-400 hover:text-yellow-300"><input id="image" name="image" type="file" class="sr-only" accept="image/*"></label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-600">Leave empty to keep current image</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-5 border-t border-gray-800">
                    <div class="flex justify-end">
                            <a href="/admin/pages/vehicles.php" class="bg-gray-700 text-gray-200 font-semibold py-3 px-6 rounded-lg hover:bg-gray-600 transition-all mr-4">Cancel</a>
                            <button type="submit" name="update_product" class="bg-yellow-400 text-black font-semibold py-3 px-8 rounded-lg hover:bg-yellow-500 transition-all shadow-md">Update Vehicle</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const makeSelect = document.getElementById('make');
        const modelSelect = document.getElementById('model');
        const initialMakeId = '<?= $product['make_id'] ?>';
        const initialModelId = '<?= $product['model_id'] ?>';

        function fetchModels(makeId, selectedModelId = null) {
            modelSelect.innerHTML = '<option>Loading...</option>';
            modelSelect.disabled = true;

            if (makeId) {
                fetch(`/admin/pages/get_models.php?make_id=${makeId}`)
                    .then(response => response.json())
                    .then(data => {
                        modelSelect.innerHTML = '<option value="">Select Model</option>';
                        if(data.length > 0) {
                            data.forEach(model => {
                                const option = document.createElement('option');
                                option.value = model.model_id;
                                option.textContent = model.model_name;
                                if (model.model_id == selectedModelId) {
                                    option.selected = true;
                                }
                                modelSelect.appendChild(option);
                            });
                            modelSelect.disabled = false;
                        } else {
                            modelSelect.innerHTML = '<option value="">No models found</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching models:', error);
                        modelSelect.innerHTML = '<option value="">Error loading</option>';
                    });
            } else {
                modelSelect.innerHTML = '<option value="">Select Make First</option>';
            }
        }

        // Fetch models for the initial make on page load
        if (initialMakeId) {
            fetchModels(initialMakeId, initialModelId);
        }

        // Add event listener for make changes
        makeSelect.addEventListener('change', function() {
            fetchModels(this.value);
        });
    });
    </script>
</body>
</html>
