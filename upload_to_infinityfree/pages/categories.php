<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Makes</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<body class="bg-black text-white min-h-screen">

    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Search and Filter bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/filterBar.php'; ?>
    <!-- Search and Filter Bar -->

    <div class="max-w-7xl mx-auto px-4 my-10">
        <h2 class="text-3xl font-serif mb-8 text-yellow-400" style="font-family: 'Trajan Pro', serif;">Makes</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
        include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
        $makes = getAllMakes($connection);
        ?>
            <!-- Makes Card -->
            <?php foreach ($makes as $make) : ?>
            <div class="bg-gray-900 rounded-xl shadow-lg flex flex-row items-center gap-4 border border-yellow-400/20 p-4 transition-all duration-300 hover:-translate-y-1 hover:bg-gray-800 hover:border-yellow-400/50 hover:shadow-2xl hover:shadow-yellow-400/10">
                <img src="<?=$make['make_image']; ?>" class="w-24 h-24 object-cover rounded-lg" alt="Featured Vehicle">
                <div class="flex flex-col justify-center flex-grow">
                    <div class="pb-4">
                        <p class="text-xl font-serif text-yellow-400 mb-1" style="font-family: 'Trajan Pro', serif;"><?=$make['make_name']; ?></p>
                    </div>
                    <div class="flex flex-row justify-between items-center">
                        <p class="text-gray-400 text-sm mb-0" style="font-size: 0.95rem;"><?= $make['listings_count'] ?> Listings</p>
                        <a href="/pages/makesListings.php?id=<?= $make['make_id'] ?>" class="ml-4">
                            <button class="flex items-center justify-center w-10 h-10 rounded-full border border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-black transition-all">
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <!-- Makes Card -->
        </div>
    </div>

    <!-- Footer -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
</body>
</html>
