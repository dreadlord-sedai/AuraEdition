<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
    ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Cart</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->


    <!-- Main Content -->
    <div class="container-md my-5 main-content">

        <div class="flex flex-col justify-content-center align-items-center gap-10">
            <!-- Cart Card -->
            <div class="flex flex-col w-75 flex-grow gap-3 justify-content-center rounded-lg align-items-center bg-gray-200 p-5">
                <h4>Cart</h4>

                <!-- Item Card -->
                <div class="flex flex-row justify-between gap-3 items-center rounded-md bg-gray-400 p-4 w-full">
                    <div class="rounded-sm">
                        <img src="/Projects/AuraEdition/assets/images/checkout1.jpg" class="img-fluid object-fit-cover aspect-square w-40" alt="">
                    </div>

                    <div class="flex flex-col items-center">
                        <div class="">
                            <h5>2023 Lamborghini Huracan</h5>
                        </div>
                        <div class="mb-2">
                            <h5>$100</h5>
                        </div>

                        <div class="flex flex-row gap-2">
                            <button class="btn btn-primary">-</button>
                            <h5 class="mx-2">1</h5>
                            <button class="btn btn-primary">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <button class="btn btn-outline-success">Buy Now</button>
                        <button class="btn btn-outline-danger">Remove</button>

                    </div>
                </div>

                <div class="flex flex-row justify-between gap-3 items-center rounded-md bg-gray-400 p-4 w-full">
                    <div class="rounded-sm">
                        <img src="/Projects/AuraEdition/assets/images/checkout1.jpg" class="img-fluid object-fit-cover aspect-square w-40" alt="">
                    </div>

                    <div class="flex flex-col items-center">
                        <div class="">
                            <h5>2023 Lamborghini Huracan</h5>
                        </div>
                        <div class="mb-2">
                            <h5>$100</h5>
                        </div>

                        <div class="flex flex-row gap-2">
                            <button class="btn btn-primary">-</button>
                            <h5 class="mx-2">1</h5>
                            <button class="btn btn-primary">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <button class="btn btn-outline-success">Buy Now</button>
                        <button class="btn btn-outline-danger">Remove</button>

                    </div>
                </div>

                <div class="flex flex-row justify-between gap-3 items-center rounded-md bg-gray-400 p-4 w-full">
                    <div class="rounded-sm">
                        <img src="/Projects/AuraEdition/assets/images/checkout1.jpg" class="img-fluid object-fit-cover aspect-square w-40" alt="">
                    </div>

                    <div class="flex flex-col items-center">
                        <div class="">
                            <h5>2023 Lamborghini Huracan</h5>
                        </div>
                        <div class="mb-2">
                            <h5>$100</h5>
                        </div>

                        <div class="flex flex-row gap-2">
                            <button class="btn btn-primary">-</button>
                            <h5 class="mx-2">1</h5>
                            <button class="btn btn-primary">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <button class="btn btn-outline-success">Buy Now</button>
                        <button class="btn btn-outline-danger">Remove</button>

                    </div>
                </div>

                <div class="flex flex-row justify-between gap-3 items-center rounded-md bg-gray-400 p-4 w-full">
                    <div class="rounded-sm">
                        <img src="/Projects/AuraEdition/assets/images/checkout1.jpg" class="img-fluid object-fit-cover aspect-square w-40" alt="">
                    </div>

                    <div class="flex flex-col items-center">
                        <div class="">
                            <h5>2023 Lamborghini Huracan</h5>
                        </div>
                        <div class="mb-2">
                            <h5>$100</h5>
                        </div>

                        <div class="flex flex-row gap-2">
                            <button class="btn btn-primary">-</button>
                            <h5 class="mx-2">1</h5>
                            <button class="btn btn-primary">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <button class="btn btn-outline-success">Buy Now</button>
                        <button class="btn btn-outline-danger">Remove</button>

                    </div>
                </div>


                <!-- Item Card -->

                <div class="flex flex-row justify-between gap-3 items-center rounded-md bg-gray-400 p-4 w-full px-5">
                    <h4>Total:</h4>
                    <h4>$400</h4>
                </div>

                <div class="flex flex-row justify-center gap-3 items-center rounded-md bg-transparent p-4 w-full">
                    <a href="/Projects/AuraEdition/pages/checkout.php" class="btn btn-primary w-3/5">CHECKOUT</a>
                </div>

            </div>
            <!-- Cart Card -->

            <!-- Buttons -->
            <div class="flex flex-row gap-3 w-full justify-content-evenly p-5 my-4 border-y-1 border-gray-400 ">
                <div class="flex w-1/2 justify-content-center">
                    <a href="/Projects/AuraEdition/pages/purchasedHistory.php" class="btn btn-primary w-3/5">PURCHASED HISTORY</a>
                </div>

                <div class="flex w-1/2 justify-content-center">
                    <a href="/Projects/AuraEdition/pages/watchlist.php" class="btn btn-primary w-3/5">WATCHLIST</a>
                </div>

            </div>
            <!-- Buttons -->

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


    </div>
    <!-- Main Content -->


    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>