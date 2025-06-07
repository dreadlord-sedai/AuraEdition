<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/header.php"; ?>

<div class="container-md my-5">
    <h2 class="text-start mb-4">Cards </h2>
    <div class="row">

        <!-- Makes Card -->
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card makes-card  d-flex flex-row align-items-center gap-3">
                <img src="/Projects/AuraEdition/products/img/makes1.jpg" class="makesCard-img" alt="Featured Vehicle">
                <div class="flex-grow-1 d-flex flex-column justify-content-center">
                    <h5 class="card-title mb-1">Dodge</h5>
                    <p class="card-text mb-0 text-muted" style="font-size: 0.95rem;">120 Listings</p>
                </div>
                <button
                    class="makesCard-btn btn btn-outline-light d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>

    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>