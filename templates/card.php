<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/header.php"; ?>

<div class="container-md my-5">
    <h2 class="text-start mb-4">Cards </h2>
    <div class="row">
        <!-- Product Card -->
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card">
                <img src="/Projects/AuraEdition/products/img/feature1.jpg" class="card-img-top" alt="Featured Vehicle">
                <div class="card-body">
                    <h5 class="card-title">2023 Lamborghini Huracan</h5>
                    <p class="card-text">$250,000</p>
                    <a href="#" class="btn btn-primary w-100">View</a>
                </div>
            </div>
        </div>
        <!-- Product Card -->

        <!-- Product Card With Wishlist Button -->
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card">
                <button class="wishlist-button btn btn-outline-light position-absolute top-0 end-0 m-2 p-2 rounded-circle shadow-sm">
                    <i class="bi bi-heart mt-1"></i>
                </button>
                <img src="/Projects/AuraEdition/products/img/listings1.jpg" class="card-img-top" alt="Listings Vehicle">
                <div class="card-body">
                    <h5 class="card-title">2024 Mustang GT 500</h5>
                    <p class="card-text">$150,000</p>
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-primary">View</a>
                        <a href="#" class="btn btn-primary"> Add to Cart</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- Product Card With Wishlist Button -->
    </div>

</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>