<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Listing</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<body class="bg-black text-white min-h-screen">

    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <div class="max-w-7xl mx-auto px-4 my-10">
        <?php
        if (isset($_GET['id'])):
            $vehicle_id = $_GET['id'];
            $vehicle = get_vehicle($vehicle_id, $connection);
        ?>
        <!-- Product Image & Gallery -->
        <div class="flex flex-col md:flex-row gap-10 justify-center">
            <!-- Main Product Image -->
            <div class="md:w-1/2 flex items-center justify-center relative">
                <div class="aspect-square w-full bg-gray-900 rounded-xl shadow-lg flex items-center justify-center border-2 border-yellow-400/20 relative">
                    <button class="absolute top-4 right-4 w-12 h-12 bg-transparent border-2 border-yellow-400 rounded-full flex items-center justify-center shadow transition hover:bg-yellow-400/10" onclick="addToWishlist(<?= $vehicle['id'] ?>)" data-id="<?= $vehicle['id'] ?>">
                        <i class="fa-solid fa-heart text-2xl text-yellow-400 transition"></i>
                    </button>
                    <img src="<?php echo get_vehicle_image($vehicle_id, $connection); ?>" alt="Main Product" class="object-cover w-full h-full rounded-xl" />
                </div>
            </div>
            <!-- Image Grid -->
            <div class="md:w-1/2 grid grid-cols-2 grid-rows-2 gap-4">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center border border-yellow-400/10">
                    <img src="<?php echo get_vehicle_image($vehicle_id, $connection); ?>" alt="Grid <?php echo $i; ?>" class="object-cover w-full h-full rounded-xl" />
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Product Details & Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start mt-8 mb-20 gap-8">
            <!-- Product Details -->
            <div class="flex flex-col gap-6 md:w-2/3">
                <div class="flex flex-row gap-10 items-center">
                    <h2 class="text-3xl font-bold font-serif text-yellow-400" style="font-family: 'Trajan Pro', serif;"><?= htmlspecialchars($vehicle['title']) ?></h2>
                    <h3 class="text-yellow-400 text-2xl font-bold">$<?= htmlspecialchars($vehicle['price']) ?></h3>
                </div>
                <p class="text-gray-300 text-lg text-left leading-relaxed"><?= htmlspecialchars($vehicle['description']) ?></p>
            </div>
            <!-- Product Details -->

            <!-- Action Buttons Section -->
            <div class="flex flex-col gap-4 md:w-1/3 w-full text-center items-center">
                <div class="flex flex-col gap-4 justify-center items-center p-6 bg-gray-900 rounded-xl shadow-lg border border-yellow-400/20 w-full max-w-xs">
                    <button class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-md hover:bg-yellow-500 transition-all text-lg tracking-wide mb-2"
                        onclick="buyNow(<?= $vehicle['id'] ?>, parseInt(document.getElementById('quantity-<?= $vehicle['id'] ?>').value) || 1);"
                        type="submit" name="submit" value="Buy Now">
                        Buy Now
                    </button>
                    <button type="button" class="w-full bg-gray-800 text-yellow-400 font-semibold py-3 rounded-md hover:bg-yellow-400 hover:text-black transition-all text-lg tracking-wide mb-2"
                        onclick="addToCart(<?= $vehicle['id'] ?>, parseInt(document.getElementById('quantity-<?= $vehicle['id'] ?>').value) || 1)">
                        Add to Cart
                    </button>
                    <div class="flex flex-row gap-2 justify-center items-center w-full">
                        <label for="quantity-<?= $vehicle['id'] ?>" class="text-gray-400">Quantity:</label>
                        <input type="number" id="quantity-<?= $vehicle['id'] ?>" name="quantity" min="1" max="<?= $vehicle['stock']; ?>" value="1" class="w-20 bg-black border border-gray-700 text-white rounded-md p-2 focus:ring-yellow-400 focus:border-yellow-400">
                    </div>
                </div>
            </div>
            <!-- Action Buttons Section -->
        </div>
        <?php endif; ?>

        <hr class="border-yellow-400/20 my-12">
        <!-- Recent Listings Section -->
        <div class="my-20">
            <h2 class="text-2xl font-serif mb-8 text-yellow-400" style="font-family: 'Trajan Pro', serif;">Recent Listings</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <?php
                $recent_vehicles = get_all_recent_vehicles($connection);
                foreach ($recent_vehicles as $vehicle) {
                    $image = get_vehicle_image($vehicle['id'], $connection);
                    $vehicle_images[$vehicle['id']] = $image ? $image : '/products/img/default.jpg';
                }
                ?>
                <?php foreach ($recent_vehicles as $vehicle): ?>
                    <div class="bg-gradient-to-br from-black via-gray-900 to-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col border border-yellow-400/20 transform transition-all duration-300 hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10 relative group">
                        <button class="absolute top-3 right-3 w-12 h-12 bg-white/80 hover:bg-yellow-400 border-2 border-yellow-400 rounded-full flex items-center justify-center shadow transition opacity-0 group-hover:opacity-100" onclick="addToWishlist(<?= $vehicle['id'] ?>)" data-id="<?= $vehicle['id'] ?>">
                            <i class="fa-solid fa-heart text-2xl text-yellow-400 transition"></i>
                        </button>
                        <a href="/products/productDetails.php?id=<?= $vehicle['id'] ?>">
                            <img src="<?= $vehicle_images[$vehicle['id']] ?>" class="w-full h-48 object-cover" alt="<?= htmlspecialchars($vehicle['title']) ?>">
                        </a>
                        <div class="p-4 flex flex-col gap-2 flex-1">
                            <h5 class="text-lg font-semibold text-white" style="font-family: 'Trajan Pro', serif;"><?= htmlspecialchars($vehicle['title']) ?></h5>
                            <p class="text-yellow-400 font-bold text-xl">$<?= number_format($vehicle['price']) ?></p>
                            <div class="flex gap-2 mt-auto">
                                <a href="/products/productDetails.php?id=<?= $vehicle['id'] ?>" class="flex-1 bg-yellow-400 text-black py-2 rounded hover:bg-yellow-500 text-center transition font-semibold">Buy Now</a>
                                <button class="flex-1 bg-gray-900 text-white py-2 rounded hover:bg-gray-700 transition font-semibold" onclick="addToCart(<?= $vehicle['id'] ?>)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
</body>
</html>
