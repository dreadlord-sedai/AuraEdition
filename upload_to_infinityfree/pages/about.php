<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | About</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<body class="bg-black text-white min-h-screen">

    <!-- Navigation Bar -->
    <nav class="z-20">
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navbarTransparent.php'; ?>
    </nav>
    <!-- Navigation Bar -->

    <!-- Hero Section -->
    <div class="relative w-full h-screen flex items-center justify-start overflow-hidden">
        <video class="absolute inset-0 w-full h-full object-cover z-0" autoplay muted loop playsinline>
            <source src="/assets/video/hero.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="relative z-20 flex flex-col gap-4 px-4 md:px-16">
            <h1 class="text-4xl md:text-6xl font-bold font-serif text-yellow-400 drop-shadow-lg tracking-wide mb-4" style="font-family: 'Trajan Pro', serif;">Discover<br>The Best Cars<br>on Earth</h1>
            <p class="text-xl md:text-2xl max-w-2xl text-gray-100 drop-shadow font-light" style="font-family: 'Inter', Arial, sans-serif;">For those who wish to pursue greatness,<br>we provide the most premier destination to realize a life well-lived.</p>
        </div>
    </div>
    <!-- Hero Section -->

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 my-20">
        <!-- About Section -->
        <div class="text-center mb-16">
            <h3 class="text-2xl md:text-3xl font-serif text-yellow-400 mb-4" style="font-family: 'Trajan Pro', serif;">Connecting Buyers and Sellers Worldwide,<br>to Facilitate Life's Most Important Personal Transactions</h3>
        </div>

        <div class="flex flex-col md:flex-row justify-evenly items-center mb-20 gap-10">
            <div class="flex-1">
                <h4 class="text-xl font-serif text-yellow-400 mb-2" style="font-family: 'Trajan Pro', serif;">The Best of the Best</h4>
                <p class="text-left text-gray-300">Through a combination of automation and manual curation, our moderation team selects the highest quality listings on the market.</p>
            </div>
            <div class="flex-1 flex justify-center">
                <img src="/assets/images/about1.jpg" alt="car" class="rounded-xl border-2 border-yellow-400/20 shadow-lg max-w-xs md:max-w-md">
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-evenly items-center mb-20 gap-10">
            <div class="flex-1 flex justify-center order-2 md:order-1">
                <img src="/assets/images/about2.jpg" alt="car" class="rounded-xl border-2 border-yellow-400/20 shadow-lg max-w-xs md:max-w-md">
            </div>
            <div class="flex-1 order-1 md:order-2">
                <h4 class="text-xl font-serif text-yellow-400 mb-2" style="font-family: 'Trajan Pro', serif;">One Search, <br>Unlimited Potential</h4>
                <p class="text-left text-gray-300">We give you back your valuable time by creating one source for all premium listings, eliminating the need to visit multiple dealers or agents to find exactly what you are looking for.</p>
            </div>
        </div>
        <!-- About Section -->
    </div>
    <!-- Main Content -->
    <div class="w-full">
        <img src="/assets/images/about3.jpg" class="w-full object-cover rounded-none md:rounded-xl border-t-2 border-yellow-400/20 shadow-lg" alt="Luxury Cars">
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
</body>
</html>
