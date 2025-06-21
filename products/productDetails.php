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
                        <img src="<?php echo get_vehicle_image($vehicle_id, $connection); ?>" alt="Main Product" class="object-cover w-full h-full rounded-lg" />
                    </div>
                </div>
                <!-- Image Grid (right, 2x2, takes half width) -->
                <div class="w-1/2 grid grid-cols-2 grid-rows-2 gap-4">
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="<?php echo get_vehicle_image($vehicle_id, $connection); ?>" alt="Grid 1" class="object-cover w-full h-full rounded-lg" />
                    </div>
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="<?php echo get_vehicle_image($vehicle_id, $connection); ?>" alt="Grid 2" class="object-cover w-full h-full rounded-lg" />
                    </div>
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="<?php echo get_vehicle_image($vehicle_id, $connection); ?>" alt="Grid 3" class="object-cover w-full h-full rounded-lg" />
                    </div>
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="<?php echo get_vehicle_image($vehicle_id, $connection); ?>" alt="Grid 4" class="object-cover w-full h-full rounded-lg" />
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="flex flex-row justify-between items-center mt-4 mb-20 p-4">
                <!-- Product Details -->
                <div class="flex flex-col gap-4 w-2/3 text-center justify-center items-start p-2">
                    <div class="flex flex-row gap-14 justify-start items-center">
                        <h2 class="text-2xl font-bold "><?= htmlspecialchars($vehicle['title']) ?></h2>
                        <h3 class="text-gray-500 ">$<?= htmlspecialchars($vehicle['price']) ?></h3>
                    </div>

                    <p class="text-gray-600 text-start"><?= htmlspecialchars($vehicle['description']) ?></p>
                </div>
                <!-- Product Details -->

                <!-- Action Buttons Section -->
                <div class="flex flex-col gap-4 w-1/3  text-center justify-center items-center p-2">
                    <div class="CTA-card flex flex-col gap-4 justify-center items-center p-2
                        bg-white/10 rounded-lg shadow-lg w-64 h-72">
                        
                            <button class="btn btn-primary d-flex justify-content-center align-items-center"
                            onclick="buyNow(<?= $vehicle['id']?>);" type="submit" name="submit" value="Buy Now">
                                Buy Now
                            </button>
                            <script>
                                // Override buyNow to include quantity from input
                                function buyNow(id) {
                                    var quantityInput = document.getElementById('quantity');
                                    var quantity = quantityInput ? parseInt(quantityInput.value) : 1;
                                    if (isNaN(quantity) || quantity < 1) {
                                        quantity = 1;
                                    }
                                    var request = new XMLHttpRequest();
                                    request.onreadystatechange = function () {
                                        if (request.readyState == 4) {
                                            if (request.status == 200) {
                                                var response = request.responseText.trim();
                                                if (response === "success") {
                                                    window.location = "/Projects/AuraEdition/pages/checkout.php";
                                                } else {
                                                    alert("Buy Now failed: " + response);
                                                }
                                            } else {
                                                alert("Request failed with status " + request.status);
                                            }
                                        }
                                    }
                                    request.open("POST", "/Projects/AuraEdition/process/buyNowProcess.php", true);
                                    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                    request.send("id=" + encodeURIComponent(id) + "&quantity=" + encodeURIComponent(quantity));
                                }
                            </script>
                        
                        <a href="/Projects/AuraEdition/pages/cart.php?id=<?= $vehicle['id'] ?>">
                            <button class="btn btn-primary d-flex justify-content-center align-items-center">
                                Add to cart
                            </button>
                        </a>

                        <div class="flex flex-row gap-2 justify-center items-center">
                            <label for="quantity" class="text-gray-600">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" min="1" max="<?= $vehicle['stock']; ?>" value="1" 
                            class="p-2 bg-white/10 rounded-lg shadow-lg w-16 h-8">
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