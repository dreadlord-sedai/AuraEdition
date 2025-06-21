<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

// Clear vehicles in session if not on checkout page
$currentScript = basename($_SERVER['SCRIPT_NAME']);
if ($currentScript !== 'checkout.php') {
    if (isset($_SESSION['vehicles'])) {
        unset($_SESSION['vehicles']);
    }
    if (isset($_SESSION['total_price'])) {
        unset($_SESSION['total_price']);
    }
}
?>
<!-- Navigation Bar -->
<nav class="w-full bg-black text-white">
    <div class="container-md flex items-center justify-between py-3">
        <a class="logo text-2xl text-white" href="/Projects/AuraEdition/index.php">AuraEdition</a>
        <ul class="flex space-x-6 list-none items-center m-0 p-0">
            <li><a class="nav-link text-white hover:text-blue-400 transition" href="/Projects/AuraEdition/index.php">Home</a></li>
            <li><a class="nav-link text-white hover:text-blue-400 transition" href="/Projects/AuraEdition/products/listings.php">Listings</a></li>
            <li><a class="nav-link text-white hover:text-blue-400 transition" href="/Projects/AuraEdition/pages/categories.php">Makes</a></li>
            <li><a class="nav-link text-white hover:text-blue-400 transition" href="/Projects/AuraEdition/pages/about.php">About</a></li>
            <li><a class="nav-link text-white hover:text-blue-400 transition" href="/Projects/AuraEdition/pages/contact.php">Contact</a></li>
            <?php
            if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
                // Display the dashboard link only for admin users
                echo '<li><a class="nav-link text-white hover:text-blue-400 transition" href="/Projects/AuraEdition/admin/dashboard.php">Dashboard</a></li>';
            }
            ?>
        </ul>
        <div class="flex items-center space-x-4">
            <a href="/Projects/AuraEdition/pages/cart.php">
                <i class="fa-solid fa-cart-shopping text-light"></i>
            </a>

            <!-- Display login or logout button based on session status -->
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<a href="/Projects/AuraEdition/process/logoutProcess.php" class="text-decoration-none text-white">
                <button class="border border-red-500 text-red-500 px-4 py-1 rounded hover:bg-red-500 hover:text-white transition d-flex align-items-center"
                onclick=logout();>
                    Logout
                </button>
            </a>';
            } else {
                echo '<a href="/Projects/AuraEdition/auth/login.php" class="text-decoration-none text-white">
                <button class="border border-green-500 text-green-500 px-4 py-1 rounded hover:bg-green-500 hover:text-white transition d-flex align-items-center">
                    Login
                </button>
            </a>';
            }
            ?>

        </div>
    </div>
</nav>
<!-- Navigation Bar -->

