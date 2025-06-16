<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Listing</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <div class="container-md my-5 main-content">

        <div>

            <?php

            if (isset($_GET['id'])):
                $vehicle_id = $_GET['id'];
                $vehicle = get_vehicle($vehicle_id, $connection);
            

            ?>

            <!--- Product Image Section -->
            <div class="flex gap-6 justify-center">
                <!-- Main Product Image (left, takes half width) -->
                <div class="w-1/2 flex items-center justify-center">
                    <div class="aspect-square w-full bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Main Product" class="object-cover w-full h-full rounded-lg" />
                    </div>
                </div>
                <!-- Image Grid (right, 2x2, takes half width) -->
                <div class="w-1/2 grid grid-cols-2 grid-rows-2 gap-4">
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 1" class="object-cover w-full h-full rounded-lg" />
                    </div>
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 2" class="object-cover w-full h-full rounded-lg" />
                    </div>
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 3" class="object-cover w-full h-full rounded-lg" />
                    </div>
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 4" class="object-cover w-full h-full rounded-lg" />
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="flex flex-row justify-between items-center mt-4 mb-20 p-4">
                <!-- Product Details -->
                <div class="flex flex-col gap-4 w-2/3 text-center justify-center items-start p-2">
                    <div class="flex flex-row gap-14 justify-start items-center">
                        <h2 class="text-2xl font-bold ">2023 Mustang GT</h2>
                        <h3 class="text-gray-500 ">$250,000</h3>
                    </div>

                    <p class="text-gray-600 text-start">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <!-- Product Details -->

                <!-- Action Buttons Section -->
                <div class="flex flex-col gap-4 w-1/3  text-center justify-center items-center p-2">
                    <div class="CTA-card flex flex-col gap-4 justify-center items-center p-2
                        bg-white/10 rounded-lg shadow-lg w-64 h-72">
                        <a href="/Projects/AuraEdition/pages/checkout.php">
                            <button class="btn btn-primary d-flex justify-content-center align-items-center">
                                Buy Now
                            </button>
                        </a>
                        <a href="/Projects/AuraEdition/pages/cart.php">
                            <button class="btn btn-primary d-flex justify-content-center align-items-center">
                                Add to cart
                            </button>
                        </a>

                        <div class="flex flex-row gap-2 justify-center items-center">
                            <label for="quantity" class="text-gray-600">Quantity:</label>
                            <select name="quantity" id="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Action Buttons Section -->
            </div>
        </div>
        <?php endif; ?>

        <hr>
        <!-- Product Details Section -->


        <!-- Recent Listings Section -->
        <div class="container-md my-20">
            <h2 class="text-start mb-4">Recent Listings</h2>
            <div class="row">

                <?php
                $recent_vehicles = get_all_recent_vehicles($connection);
                foreach ($recent_vehicles as $vehicle) {
                    $image = get_vehicle_image($vehicle['id'], $connection);
                    $vehicle_images[$vehicle['id']] = $image ? $image : '/Projects/AuraEdition/products/img/default.jpg';
                }

                ?>

                <!-- Vehicle card-->
                <?php foreach ($recent_vehicles as $vehicle): ?>
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <div class="card">
                            <button class="wishlist-button btn btn-outline-light position-absolute top-0 end-0 m-2 p-2 rounded-circle shadow-sm">
                                <i class="bi bi-heart mt-1"></i>
                            </button>
                            <a href="/Projects/AuraEdition/products/productDetails.php?id=<?= $vehicle['id'] ?>">
                                <img src="<?= $vehicle_images[$vehicle['id']] ?>" class="card-img-top" alt="<?= htmlspecialchars($vehicle['title']) ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($vehicle['title']) ?></h5>
                                <p class="card-text">$<?= number_format($vehicle['price']) ?></p>
                                <div class="d-flex gap-2">
                                    <a href="/Projects/AuraEdition/products/productDetails.php?id=<?= $vehicle['id'] ?>" class="btn btn-primary">Buy Now</a>
                                    <a href="/Projects/AuraEdition/pages/cart.php?id=<?= $vehicle['id'] ?>" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- Vehicle card-->
            </div>
        </div>



    </div>


    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>