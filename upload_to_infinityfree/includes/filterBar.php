<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

// filterBar.php
$selected_make = $_GET['make'] ?? '';
$selected_model = $_GET['model'] ?? '';
$price = $_GET['price'] ?? '';
$q = $_GET['q'] ?? '';

// Fetch all makes
$makes = getAllMakes($connection);
// Fetch models using the new function
$models = getModels($connection, $selected_make ?: null);
?>
<nav class="bg-black py-4 border-b-2 border-yellow-400/30">
    <div class="max-w-7xl mx-auto px-4">
        <form action="/products/listings.php" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center" role="search">
            
            <!-- Filter Options -->
            <div class="col-span-1 md:col-span-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <select class="bg-gray-900 border border-gray-700 text-white rounded-md p-2 focus:ring-yellow-400 focus:border-yellow-400" name="make" aria-label="Filter by make">
                    <option value="" <?= $selected_make == '' ? 'selected' : '' ?>>All Makes</option>
                    <?php foreach ($makes as $m): ?>
                        <option value="<?= htmlspecialchars($m['make_name']) ?>" <?= $selected_make == $m['make_name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['make_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select class="bg-gray-900 border border-gray-700 text-white rounded-md p-2 focus:ring-yellow-400 focus:border-yellow-400" name="model" aria-label="Filter by model">
                    <option value="" <?= $selected_model == '' ? 'selected' : '' ?>>All Models</option>
                    <?php foreach ($models as $mod): ?>
                        <option value="<?= htmlspecialchars($mod['model_name']) ?>" <?= $selected_model == $mod['model_name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($mod['model_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select class="bg-gray-900 border border-gray-700 text-white rounded-md p-2 focus:ring-yellow-400 focus:border-yellow-400" name="price" aria-label="Filter by price">
                    <option value="" <?= $price == '' ? 'selected' : '' ?>>Any Price</option>
                    <option value="under100" <?= $price == 'under100' ? 'selected' : '' ?>>Under $100,000</option>
                    <option value="100to250" <?= $price == '100to250' ? 'selected' : '' ?>>$100,000 - $250,000</option>
                    <option value="over250" <?= $price == 'over250' ? 'selected' : '' ?>>Over $250,000</option>
                </select>

                <button class="bg-yellow-400 text-black font-semibold py-2 rounded-md hover:bg-yellow-500 transition-all" type="submit">Filter</button>
            </div>

            <!-- Search Bar -->
            <div class="col-span-1 flex items-center gap-2">
                <input class="w-full bg-gray-900 border border-gray-700 text-white rounded-md p-2 focus:ring-yellow-400 focus:border-yellow-400" type="search" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search vehicles..." aria-label="Search">
                <a href="/products/listings.php" class="text-gray-400 hover:text-white font-semibold transition-all">Reset</a>
            </div>
        </form>
    </div>
</nav>
