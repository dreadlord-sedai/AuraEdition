<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

$items_per_page = 9;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Use the new get_filter_values function
$filter_results = get_filter_values($connection, $items_per_page, $offset);
$All_vehicles = $filter_results['All_vehicles'];
$vehicle_images = $filter_results['vehicle_images'];
$total_vehicles = $filter_results['total_vehicles'];
$total_pages = $filter_results['total_pages'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Listings</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body class="bg-black text-white min-h-screen">

    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Search and Filter bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/filterBar.php'; ?>
    <!-- Search and Filter Bar -->

    <div class="max-w-7xl mx-auto px-4 my-10">
        <h2 class="text-3xl font-serif mb-8 text-yellow-400" style="font-family: 'Trajan Pro', serif;">All Listings</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <!-- Product Cards -->
            <?php foreach ($All_vehicles as $vehicle): ?>
                <div class="bg-gradient-to-br from-black via-gray-900 to-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col border border-yellow-400/20 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <div class="relative">
                        <button class="absolute top-3 right-3 bg-white/80 hover:bg-yellow-400 rounded-full p-2 shadow transition" onclick="addToWishlist(<?= $vehicle['id'] ?>)" data-id="<?= $vehicle['id'] ?>">
                            <i class="bi bi-heart text-xl text-gray-700"></i>
                        </button>
                        <a href="/Projects/AuraEdition/products/productDetails.php?id=<?= $vehicle['id'] ?>">
                            <img src="<?= $vehicle_images[$vehicle['id']] ?>" class="w-full h-48 object-cover" alt="<?= htmlspecialchars($vehicle['title']) ?>">
                        </a>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <h5 class="text-lg font-semibold text-white" style="font-family: 'Trajan Pro', serif;"><?= htmlspecialchars($vehicle['title']) ?></h5>
                        <p class="text-yellow-400 font-bold text-xl">$<?= number_format($vehicle['price']) ?></p>
                        <div class="flex gap-2 mt-auto">
                            <a href="/Projects/AuraEdition/products/productDetails.php?id=<?= $vehicle['id'] ?>" class="flex-1 bg-yellow-400 text-black py-2 rounded hover:bg-yellow-500 text-center transition font-semibold">Buy Now</a>
                            <button class="flex-1 bg-gray-900 text-white py-2 rounded hover:bg-gray-700 transition font-semibold" onclick="addToCart(<?= $vehicle['id'] ?>)">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Product Cards -->
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-12">
            <ul class="flex justify-center items-center space-x-2">
                <?php if ($page > 1): ?>
                    <li>
                        <a class="px-4 py-2 bg-gray-900 border border-gray-700 text-white rounded-md hover:bg-gray-800" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li>
                        <a class="px-4 py-2 border border-gray-700 rounded-md <?= $i == $page ? 'bg-yellow-400 text-black' : 'bg-gray-900 text-white hover:bg-gray-800' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($page < $total_pages): ?>
                    <li>
                        <a class="px-4 py-2 bg-gray-900 border border-gray-700 text-white rounded-md hover:bg-gray-800" href="?page=<?= $page + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- Pagination -->
    </div>

    <!-- Footer -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>
</body>
</html>