<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | About</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <nav class="z-20">
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbarTransparent.php'; ?>
    </nav>
    <!-- Navigation Bar -->

    <!-- Hero Section -->
    <div class="w-full min-h-screen">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
            <source src="/Projects/AuraEdition/assets/video/hero.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <!-- Overlay text -->
        <div class="absolute top-1/2 left-1/15 -translate-y-1/2 text-white text-left z-10">
            <h1 class="text-4xl font-bold">Discover<br>The Best Cars<br>on Earth</h1>
            <p class="text-xl">For those who wish to pursue greatness,<br>
                we provide the most premier destination to realize<br>
                a life well-lived.</p>
        </div>
    </div>
    <!-- Hero Section -->

    <!-- Main Content -->
    <div class="container my-20 main-content">

        <!-- About Section -->
        <div class="text-center mb-10">
            <h3 class="">Connecting Buyers and Sellers Worldwide,<br>
                to Facilitate Life's Most Important <br>
                Personal Transactions</h3>
            </h2>
        </div>

        <div class="flex flex-row justify-evenly items-center mb-30 mt-30">
            <div class="">
                <h4>The Best of the Best</h4>
                <p class="text-left">Through a combination of automation and manual <br>
                    curation our moderation team selects the highest <br>
                    quality listings on the market.</p>
            </div>

            <div class="w-lg">
                <img src="/Projects/AuraEdition/assets/images/about1.jpg" alt="car">
            </div>
        </div>

        <div class="flex flex-row justify-evenly items-center mb-20 mt-30">
            <div class="w-lg">
                <img src="/Projects/AuraEdition/assets/images/about2.jpg" alt="car">
            </div>
            <div class="">
                <h4>One Search, <br>
                    Unlimited Potential</h4>
                <p class="text-left">
                    We give you back your valuable time by creating <br>
                    one source for all premium listings, eliminating the<br>
                    need to visit multiple dealers or agents to find<br>
                    exactly what you are looking for.
                </p>
            </div>
        </div>

    </div>


    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>