<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Listings</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Search and Filter bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/filterBar.php'; ?>
    <!-- Search and Filter Bar -->

    <div class="container-md my-5 main-content">
        <h2 class="text-start mb-4">All Listings</h2>
        <div class="row">

            <?php
            $All_vehicles = get_all_vehicles($connection);
            foreach ($All_vehicles as $vehicle) {
                $image = get_vehicle_image($vehicle['id'], $connection);
                $vehicle_images[$vehicle['id']] = $image ? $image : '/Projects/AuraEdition/products/img/default.jpg';
            }

            ?>

            <!-- Product Cards -->
            <?php foreach ($All_vehicles as $vehicle): ?>
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
            <!-- Product Cards -->



            <!-- Pagination -->
            <nav aria-label="Page navigation" class="PageNavigation">
                <ul class="pagination justify-content-center gap-2">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- Pagination -->

        </div>
    </div>




    <!-- Footer -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>