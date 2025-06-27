<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Home</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

</head>

<body class="bg-black min-h-screen text-white">

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Hero Section -->
    <div class="relative w-full h-[500px] md:h-[700px] flex items-center justify-start overflow-hidden bg-cover bg-center" style="background-image: url('./assets/images/hero-img.png');">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        <div class="relative z-10 flex flex-col gap-4 px-4 md:px-10">
            <h1 class="text-4xl md:text-6xl font-bold font-serif text-yellow-400 drop-shadow-lg tracking-wide" style="font-family: 'Trajan Pro', serif;">AuraEdition</h1>
            <p class="text-lg md:text-2xl max-w-xl text-gray-100 drop-shadow font-light" style="font-family: 'Inter', Arial, sans-serif;">Explore 31,000+ luxury cars, supercars and exotic cars for sale worldwide in one simple search</p>
        </div>
    </div>
    <!-- Hero Section -->

    <!-- Main Content Wrapper -->
    <div class="bg-black">
        <!-- Popular Makes Section -->
        <div class="max-w-6xl mx-auto my-12 px-4">
            <h2 class="text-2xl font-semibold mb-6 text-yellow-400 font-serif tracking-wide" style="font-family: 'Trajan Pro', serif;">Popular Makes</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-6">
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-1.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-2.jpg" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-3.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-4.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-5.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-6.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-7.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-8.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-9.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-10.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-11.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
                <div class="aspect-square bg-gray-900 rounded-xl shadow-lg flex items-center justify-center p-4 border border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                    <img src="./assets/images/make-12.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
                </div>
            </div>
        </div>
        <!-- Popular Makes Section -->

        <!-- Featured Vehicles Section -->
        <?php
        $featured_vehicles = get_featured_vehicles($connection, 3);
        foreach ($featured_vehicles as $vehicle) {
            $image = get_vehicle_image($vehicle['id'], $connection);
            $vehicle_images[$vehicle['id']] = $image ? $image : '/Projects/AuraEdition/products/img/default.jpg';
        }
        ?>
        <div class="max-w-6xl mx-auto my-12 px-4">
            <h2 class="text-2xl font-semibold mb-6 text-yellow-400 font-serif tracking-wide" style="font-family: 'Trajan Pro', serif;">Featured</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <?php foreach ($featured_vehicles as $vehicle): ?>
                    <div class="bg-gradient-to-br from-black via-gray-900 to-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col border border-yellow-400/20 group">
                        <div class="relative">
                            <button class="absolute top-3 right-3 w-12 h-12 bg-white/80 hover:bg-yellow-400 border-2 border-yellow-400 rounded-full flex items-center justify-center shadow transition opacity-0 group-hover:opacity-100" onclick="addToWishlist(<?= $vehicle['id'] ?>)" data-id="<?= $vehicle['id'] ?>">
                                <i class="fa-solid fa-heart text-2xl text-yellow-400 transition"></i>
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
            </div>
        </div>
        <!-- Featured Vehicles Section -->

        <!-- Popular Vehicles Section -->
        <?php
        $popular_vehicles = get_popular_vehicles($connection, 3);
        foreach ($popular_vehicles as $vehicle) {
            $image = get_vehicle_image($vehicle['id'], $connection);
            $vehicle_images[$vehicle['id']] = $image ? $image : '/Projects/AuraEdition/products/img/default.jpg';
        }
        ?>
        <div class="max-w-6xl mx-auto my-12 px-4">
            <h2 class="text-2xl font-semibold mb-6 text-yellow-400 font-serif tracking-wide" style="font-family: 'Trajan Pro', serif;">Popular</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <?php foreach ($popular_vehicles as $vehicle): ?>
                    <div class="bg-gradient-to-br from-black via-gray-900 to-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col border border-yellow-400/20 group">
                        <div class="relative">
                            <button class="absolute top-3 right-3 w-12 h-12 bg-white/80 hover:bg-yellow-400 border-2 border-yellow-400 rounded-full flex items-center justify-center shadow transition opacity-0 group-hover:opacity-100" onclick="addToWishlist(<?= $vehicle['id'] ?>)" data-id="<?= $vehicle['id'] ?>">
                                <i class="fa-solid fa-heart text-2xl text-yellow-400 transition"></i>
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
            </div>
        </div>
        <!-- Popular Vehicles Section -->
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>

</body>

</html>