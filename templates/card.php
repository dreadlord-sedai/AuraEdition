<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/header.php"; ?>

<div class="container-md my-5">
    <h2 class="text-start mb-4">Card </h2>
    <div class="row">
        <!-- Product Card -->
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card">
                <button class="wishlist-button btn btn-outline-light position-absolute top-0 end-0 m-2 p-2 rounded-circle shadow-sm">
                    <i class="bi bi-heart mt-1"></i>
                </button>
                <a href="/Projects/AuraEdition/products/productDetails.php">
                    <img src="/Projects/AuraEdition/products/img/feature1.jpg" class="card-img-top" alt="Featured Vehicle">
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
        <!-- Product Card With Wishlist Button -->
    </div>


    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
    $featured_vehicles = get_featured_vehicles($connection, 3);
    foreach ($featured_vehicles as $vehicle) {
        $image = get_vehicle_image($vehicle['id'], $connection);
        $vehicle_images[$vehicle['id']] = $image ? $image : '/Projects/AuraEdition/products/img/default.jpg';
    }
    ?>

    <!-- Card with backend data -->
    <div class="container-md my-5">
        <h2 class="text-start mb-4">Cards Generated</h2>
        <div class="row">
            <?php foreach ($featured_vehicles as $vehicle): ?>
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
        </div>
    </div>
    <!-- Card with backend data -->

    <!--Makes Card -->
    <div class="container-md my-5 main-content">
        <h2 class="text-start mb-4">Makes</h2>
        <div class="row">

        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
        include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
        $makes = getAllMakes($connection);
        ?>

            <!-- Makes Card -->
            <?php foreach ($makes as $make) : ?>
            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card makes-card  d-flex flex-row align-items-center gap-3">
                    <img src="<?=$make['make_image']; ?>" class="makesCard-img" alt="Featured Vehicle">
                    <div class="d-flex flex-column justify-content-center flex-grow-1">

                        <div class="pb-4">
                            <p class="makesCard-title mb-1"><?=$make['make_name']; ?></p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-text mb-0 text-muted" style="font-size: 0.95rem;">120 Listings</p>
                            <a href="/Projects/AuraEdition/pages/categories.php?id=<?= $make['make_id'] ?>" class="text-decoration-none">
                                <button class="makesCard-btn btn btn-outline-light d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <!-- Makes Card -->
             
        </div>
    </div>

</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>