<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | About</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <nav class="fixed top-0 left-0 w-full z-20">
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


    <div class="container-md my-5 main-content">

        <!-- About Section -->

    </div>


    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>