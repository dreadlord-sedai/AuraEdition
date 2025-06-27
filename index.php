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

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Hero Section -->
    <div class="relative w-full h-[350px] md:h-[500px] flex items-center justify-center overflow-hidden">
        <img src="./assets/images/hero-img.png" alt="Hero" class="object-cover w-full h-full brightness-75">
        <div class="absolute top-1/2 left-10 -translate-y-1/2 text-white flex flex-col gap-2">
            <h1 class="text-4xl md:text-6xl font-bold drop-shadow-lg">AuraEdition</h1>
            <p class="text-lg md:text-2xl max-w-xl drop-shadow">Explore 31,000+ luxury cars, supercars and exotic cars for sale worldwide in one simple search</p>
        </div>
    </div>
    <!-- Hero Section -->

    <!-- Popular Makes Section -->
    <div class="max-w-6xl mx-auto my-12 px-4">
        <h2 class="text-2xl font-semibold mb-6">Popular Makes</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-6">
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-1.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-2.jpg" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-3.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-4.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-5.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-6.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-7.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-8.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-9.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-10.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
                <img src="./assets/images/make-11.png" alt="car_brand" class="w-3/4 h-3/4 object-contain">
            </div>
            <div class="aspect-square bg-white rounded-lg shadow flex items-center justify-center p-4">
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
        <h2 class="text-2xl font-semibold mb-6">Featured</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <?php foreach ($featured_vehicles as $vehicle): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <div class="relative">
                        <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow transition" onclick="addToWishlist(<?= $vehicle['id'] ?>)" data-id="<?= $vehicle['id'] ?>">
                            <i class="bi bi-heart text-xl text-gray-700"></i>
                        </button>
                        <a href="/Projects/AuraEdition/products/productDetails.php?id=<?= $vehicle['id'] ?>">
                            <img src="<?= $vehicle_images[$vehicle['id']] ?>" class="w-full h-48 object-cover" alt="<?= htmlspecialchars($vehicle['title']) ?>">
                        </a>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <h5 class="text-lg font-semibold"><?= htmlspecialchars($vehicle['title']) ?></h5>
                        <p class="text-blue-600 font-bold text-xl">$<?= number_format($vehicle['price']) ?></p>
                        <div class="flex gap-2 mt-auto">
                            <a href="/Projects/AuraEdition/products/productDetails.php?id=<?= $vehicle['id'] ?>" class="flex-1 bg-blue-600 text-white py-2 rounded hover:bg-blue-700 text-center transition">Buy Now</a>
                            <button class="flex-1 bg-gray-900 text-white py-2 rounded hover:bg-gray-700 transition" onclick="addToCart(<?= $vehicle['id'] ?>)">Add to Cart</button>
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
        <h2 class="text-2xl font-semibold mb-6">Popular</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <?php foreach ($popular_vehicles as $vehicle): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                    <div class="relative">
                        <button class="absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow transition" onclick="addToWishlist(<?= $vehicle['id'] ?>)" data-id="<?= $vehicle['id'] ?>">
                            <i class="bi bi-heart text-xl text-gray-700"></i>
                        </button>
                        <a href="/Projects/AuraEdition/products/productDetails.php?id=<?= $vehicle['id'] ?>">
                            <img src="<?= $vehicle_images[$vehicle['id']] ?>" class="w-full h-48 object-cover" alt="<?= htmlspecialchars($vehicle['title']) ?>">
                        </a>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <h5 class="text-lg font-semibold"><?= htmlspecialchars($vehicle['title']) ?></h5>
                        <p class="text-blue-600 font-bold text-xl">$<?= number_format($vehicle['price']) ?></p>
                        <div class="flex gap-2 mt-auto">
                            <a href="/Projects/AuraEdition/products/productDetails.php?id=<?= $vehicle['id'] ?>" class="flex-1 bg-blue-600 text-white py-2 rounded hover:bg-blue-700 text-center transition">Buy Now</a>
                            <button class="flex-1 bg-gray-900 text-white py-2 rounded hover:bg-gray-700 transition" onclick="addToCart(<?= $vehicle['id'] ?>)">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Popular Vehicles Section -->

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>