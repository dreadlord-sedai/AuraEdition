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
    <div class="Hero">
        <img src="./assets/images/hero-img.png" alt="Hero" class="img-fluid w-100">
        <div class="position-absolute top-50 align-items-start text-white ms-5 ">
            <h1>AuraEdition</h1>
            <p>Explore 31,000+ luxury cars, supercars and exotic cars for sale worldwide in one
                simple search</p>
        </div>
    </div>

    <!-- Hero Section -->

    <!-- Popular Makes Section -->
    <div class="container-md my-5 main-content">
        <h2 class="text-start mb-4">Popular Makes</h2>
        <div class="row">

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-1.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-2.jpg" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-3.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-4.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-5.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-6.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-7.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-8.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-9.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-10.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-11.png" alt="car_brand">
                </div>
            </div>

            <div class="col-2 mb-4">
                <div class="square-card align-items-center d-flex justify-content-center">
                    <img src="./assets/images/make-12.png" alt="car_brand">
                </div>
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

    <div class="container-md my-5">
        <h2 class="text-start mb-4">Featured</h2>
        <div class="row">
            <?php foreach ($featured_vehicles as $vehicle): ?>
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card">
                        <button class="wishlist-button btn btn-outline-light position-absolute top-0 end-0 m-2 p-2 rounded-circle shadow-sm">
                            <i class="bi bi-heart mt-1"></i>
                        </button>
                        <a href="/Projects/AuraEdition/products/productDetails.php?id=<?= $vehicle['id'] ?>">
                            <img src="/Projects/AuraEdition/products/img/<?= $vehicle_images[$vehicle['id']] ?>" class="card-img-top" alt="<?= htmlspecialchars($vehicle['title']) ?>">
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
        </div>
    </div>

    <!-- Featured Vehicles Section -->

    <!-- Popular Vehicles Section -->
    <div class="container-md my-5">
        <h2 class="text-start mb-4">Popular</h2>
        <div class="row">

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card">
                    <button class="wishlist-button btn btn-outline-light position-absolute top-0 end-0 m-2 p-2 rounded-circle shadow-sm">
                        <i class="bi bi-heart mt-1"></i>
                    </button>
                    <a href="/Projects/AuraEdition/products/productDetails.php">
                        <img src="./products/img/feature2.jpg" class="card-img-top" alt="Featured Vehicle">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">2023 Lamborghini Huracan</h5>
                        <p class="card-text">$250,000</p>
                        <div class="d-flex gap-2">
                            <a href="/Projects/AuraEdition/products/productDetails.php" class="btn btn-primary">Buy Now</a>
                            <a href="/Projects/AuraEdition/pages/cart.php" class="btn btn-primary"> Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Vehicles Section -->

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>