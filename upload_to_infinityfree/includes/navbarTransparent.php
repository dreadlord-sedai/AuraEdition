<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
?>
<!-- Transparent Navigation Bar -->
<nav class="absolute top-0 left-0 w-full z-30 text-white transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between py-4">
        <a class="logo text-3xl text-yellow-400 font-serif tracking-wider" href="/index.php" style="font-family: 'Trajan Pro', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">AuraEdition</a>
        
        <!-- Main Navigation Links -->
        <ul class="hidden md:flex space-x-8 list-none items-center m-0 p-0">
            <li><a class="nav-link text-white" href="/index.php" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.4);">Home</a></li>
            <li><a class="nav-link text-white" href="/products/listings.php" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.4);">Listings</a></li>
            <li><a class="nav-link text-white" href="/pages/categories.php" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.4);">Makes</a></li>
            <li><a class="nav-link text-white" href="/pages/about.php" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.4);">About</a></li>
            <li><a class="nav-link text-white" href="/pages/contact.php" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.4);">Contact</a></li>
            <?php
            if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
                echo '<li><a class="nav-link text-white" href="/admin/dashboard.php" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.4);">Dashboard</a></li>';
            }
            ?>
        </ul>

        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <a href="/pages/cart.php" class="text-gray-300 hover:text-yellow-400 transition">
                <i class="fa-solid fa-cart-shopping text-xl" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.4);"></i>
            </a>

            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<a href="/pages/account.php" class="hidden md:inline-block">
                    <button class="px-4 py-2 rounded-md border border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-black font-semibold transition-all duration-300">
                        My Account
                    </button>
                </a>
                <a href="/process/logoutProcess.php" class="hidden md:inline-block">
                    <button class="px-4 py-2 rounded-md border border-gray-500 text-gray-400 hover:bg-gray-700 hover:text-white font-semibold transition-all duration-300" onclick="logout();">
                        Logout
                    </button>
                </a>';
            } else {
                echo '<a href="/auth/register.php" class="hidden md:inline-block">
                    <button class="px-4 py-2 rounded-md border border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-black font-semibold transition-all duration-300">
                        Register
                    </button>
                </a>
                <a href="/auth/login.php" class="hidden md:inline-block">
                    <button class="px-4 py-2 rounded-md bg-yellow-400 text-black hover:bg-yellow-500 font-semibold transition-all duration-300">
                    Login
                </button>
            </a>';
            }
            ?>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </div>
</nav>
<!-- Transparent Navigation Bar -->
