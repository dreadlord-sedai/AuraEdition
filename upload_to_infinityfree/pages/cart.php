<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Cart</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<body class="bg-black text-white min-h-screen">

    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>
    <!-- Navigation Bar -->


    <!-- Main Content -->
    <div class="max-w-5xl mx-auto my-12 px-4">
        <div class="flex flex-col items-center gap-10">

            <!-- Cart Card -->
            <div class="w-full max-w-3xl flex flex-col gap-6 rounded-xl bg-gray-900 border border-yellow-400/20 shadow-lg p-8">
                <h2 class="text-3xl font-serif text-yellow-400 mb-2" style="font-family: 'Trajan Pro', serif;">Cart</h2>

                <?php
                $user_id = $_SESSION['user_id'] ?? null;
                $cart_items = getCartItemsByUserId($connection, $user_id);
                $total_price = 0;

                if (empty($cart_items)) :
                ?>
                    <p class="text-center text-gray-400">Your cart is empty.</p>
                <?php else : ?>
                    <?php foreach ($cart_items as $item) :
                        $total_price += $item['price'] * $item['quantity'];
                    ?>
                        <div class="cart-item-row flex flex-col md:flex-row justify-between gap-6 items-center rounded-lg bg-gradient-to-br from-black via-gray-900 to-gray-800 border border-yellow-400/10 p-6 w-full shadow group relative" data-price="<?= htmlspecialchars($item['price']) ?>">
                            <div class="rounded-lg overflow-hidden w-32 h-32 flex-shrink-0 border border-yellow-400/10 bg-gray-800 flex items-center justify-center">
                                <img src="<?= htmlspecialchars($item['image_path']) ?>" class="object-cover w-full h-full" alt="<?= htmlspecialchars($item['title']) ?>">
                            </div>
                            <div class="flex flex-col items-center flex-1">
                                <h5 class="text-xl font-serif text-yellow-400 mb-1" style="font-family: 'Trajan Pro', serif;"><?= htmlspecialchars($item['title']) ?></h5>
                                <div class="mb-2">
                                    <span class="text-yellow-400 font-bold text-lg">$<?= number_format($item['price']) ?></span>
                                </div>
                                <!-- Quantity -->
                                <div class="flex flex-row gap-2 items-center">
                                    <button class="w-10 h-10 bg-black border-2 border-yellow-400 rounded-full flex items-center justify-center text-yellow-400 text-xl font-bold hover:bg-yellow-400 hover:text-black transition btn-minus" data-cart-item-id="<?= htmlspecialchars($item['cart_item_id']); ?>">-</button>
                                    <span class="text-lg font-semibold quantity-display" id="quantity-<?= htmlspecialchars($item['cart_item_id']); ?>">
                                        <?= htmlspecialchars($item['quantity']); ?>
                                    </span>
                                    <button class="w-10 h-10 bg-black border-2 border-yellow-400 rounded-full flex items-center justify-center text-yellow-400 text-xl font-bold hover:bg-yellow-400 hover:text-black transition btn-plus" data-cart-item-id="<?= htmlspecialchars($item['cart_item_id']); ?>">+</button>
                                </div>
                                <!-- Quantity -->
                            </div>
                            <div class="flex flex-col items-center gap-2 mt-4 md:mt-0">
                                <button class="w-32 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition shadow" onclick="buyNow(<?= $item['vehicle_id'] ?>, parseInt(document.getElementById('quantity-<?= htmlspecialchars($item['cart_item_id']); ?>').textContent) || 1)" data-id="<?= $item['vehicle_id'] ?>">Buy Now</button>
                                <button class="w-32 py-2 bg-gray-800 text-yellow-400 border border-yellow-400 rounded-lg hover:bg-yellow-400 hover:text-black transition shadow" onclick="removeFromCart(<?= $item['cart_item_id'] ?>)" data-id="<?= $item['cart_item_id'] ?>">Remove</button>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Total -->
                    <div class="flex flex-row justify-between items-center rounded-lg bg-black border-t-2 border-yellow-400/20 p-6 w-full mt-2">
                        <h4 class="font-serif text-yellow-400 text-xl" style="font-family: 'Trajan Pro', serif;">Total:</h4>
                        <h4 class="font-bold text-yellow-400 text-xl" id="cart-total-price">$<?= number_format($total_price, 2) ?></h4>
                    </div>

                    <div class="flex flex-row justify-center items-center w-full mt-4">
                        <a href="/process/cartCheckoutProcess.php" class="w-2/3 py-3 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition text-lg text-center shadow">CHECKOUT</a>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Cart Card -->

            <!-- Buttons -->
            <div class="flex flex-row gap-6 w-full justify-evenly p-6 my-4 border-y border-yellow-400/10">
                <div class="flex w-1/2 justify-center">
                    <a href="/pages/purchasedHistory.php" class="w-2/3 py-3 bg-gray-900 text-yellow-400 border border-yellow-400 rounded-lg hover:bg-yellow-400 hover:text-black transition text-lg text-center shadow">PURCHASED HISTORY</a>
                </div>
                <div class="flex w-1/2 justify-center">
                    <a href="/pages/wishlist.php" class="w-2/3 py-3 bg-gray-900 text-yellow-400 border border-yellow-400 rounded-lg hover:bg-yellow-400 hover:text-black transition text-lg text-center shadow">WISHLIST</a>
                </div>
            </div>
            <!-- Buttons -->

            <!-- Recent Listings Section -->
            <div class="w-full my-20">
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
            <!-- Recent Listings Section -->
        </div>
    </div>
    <!-- Main Content -->


    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
</body>
</html>
