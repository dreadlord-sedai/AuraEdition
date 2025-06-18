<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Makes</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Search and Filter bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/filterBar.php'; ?>
    <!-- Search and Filter Bar -->

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
                            <p class="card-text mb-0 text-muted" style="font-size: 0.95rem;"><?= $make['listings_count'] ?> Listings</p>
                            <a href="/Projects/AuraEdition/pages/makesListings.php?id=<?= $make['make_id'] ?>" class="text-decoration-none">
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



    <!-- Footer -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>