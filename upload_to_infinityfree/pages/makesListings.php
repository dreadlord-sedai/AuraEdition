<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

// Get the make_id from URL
$make_id = isset($_GET['id']) ? $_GET['id'] : null;

// Redirect if no make_id is provided
if (!$make_id) {
    header('Location: categories.php');
    exit();
}

// Get the make details
$make = getMakeById($connection, $make_id);

// If make not found, redirect or show error
if (!$make) {
    echo "<div class='alert alert-danger'>Make not found.</div>";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php";
    exit();
}

// Get listings for this specific make
$listings = getListingsByMake($connection, $make_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | <?php echo htmlspecialchars($make['make_name']); ?> Listings</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
</head>

<body class="bg-black text-white min-h-screen">
    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

    <!-- Search and Filter bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/filterBar.php'; ?>

    <div class="max-w-7xl mx-auto px-4 my-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <h2 class="text-3xl font-serif text-yellow-400" style="font-family: 'Trajan Pro', serif;">
                <?php echo $make['make_name']; ?> Listings
            </h2>
            <p class="text-gray-400 text-lg"><?php echo count($listings); ?> vehicles found</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <?php if (!empty($listings)) : ?>
                <?php foreach ($listings as $listing) : ?>
                    <div class="bg-gradient-to-br from-black via-gray-900 to-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col border border-yellow-400/20 transform transition-all duration-300 hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                        <a href="/products/productDetails.php?id=<?php echo $listing['listing_id']; ?>">
                            <img src="<?php echo $listing['image_url']; ?>" class="w-full h-48 object-cover" alt="<?php echo $listing['title']; ?>">
                        </a>
                        <div class="p-4 flex flex-col gap-2 flex-1">
                            <h5 class="text-lg font-semibold text-white" style="font-family: 'Trajan Pro', serif;"><?php echo $listing['title']; ?></h5>
                            <div class="flex flex-row justify-between items-center mt-auto">
                                <p class="text-yellow-400 font-bold text-xl">$<?php echo number_format($listing['price']); ?></p>
                                <a href="/products/productDetails.php?id=<?php echo $listing['listing_id']; ?>" class="ml-4 bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500 font-semibold transition-all">View Details</a>
                            </div>
                        </div>
                        <button class="absolute top-3 right-3 w-12 h-12 bg-white/80 hover:bg-yellow-400 border-2 border-yellow-400 rounded-full flex items-center justify-center shadow transition" onclick="addToWishlist(<?= $listing['listing_id'] ?>)" data-id="<?= $listing['listing_id'] ?>">
                            <i class="fa-solid fa-heart text-2xl text-yellow-400 group-hover:text-black transition"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-span-1 sm:col-span-2 md:col-span-3">
                    <div class="bg-gray-900 border-l-4 border-yellow-400 text-yellow-400 px-6 py-4 rounded-xl text-lg font-semibold">
                        No listings found for <?php echo $make['make_name']; ?> at this time.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
</body>

</html>
