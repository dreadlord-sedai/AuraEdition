<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

// Get the make_id from URL
$make_id = isset($_GET['id']) ? $_GET['id'] : null;

// Redirect if no make_id is provided
if (!$make_id) {
    header('Location: categories.php');
    exit();
}

// Get the make details
$make = getMakeById($connection, $make_id);

// Get listings for this specific make
$listings = getListingsByMake($connection, $make_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | <?php echo $make['make_name']; ?> Listings</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>
</head>

<body>
    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>

    <!-- Search and Filter bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/filterBar.php'; ?>

    <div class="container-md my-5 main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-start"><?php echo $make['make_name']; ?> Listings</h2>
            <p class="mb-0"><?php echo count($listings); ?> vehicles found</p>
        </div>

        <div class="row">
            <?php if (!empty($listings)) : ?>
                <?php foreach ($listings as $listing) : ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card listing-card">
                            <img src="<?php echo $listing['image_url']; ?>" class="card-img-top listing-img" alt="<?php echo $listing['title']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $listing['title']; ?></h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="card-text fw-bold mb-0">$<?php echo number_format($listing['price']); ?></p>
                                    <a href="/Projects/AuraEdition/products/productDetails.php?id=<?php echo $listing['listing_id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No listings found for <?php echo $make['make_name']; ?> at this time.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>
</body>

</html>
