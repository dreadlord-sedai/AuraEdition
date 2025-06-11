<!-- Only show page if user is logged in -->
 <?php
 include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

 if (isset($_SESSION['user_id'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
    $user = getUser($connection, $_SESSION['user_id']);
    if ($user['role'] == 1) {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminNavbar.php';
    }
 }
 ?>

<?php

?>
<!-- Navigation Bar -->
<nav class="w-full bg-black text-white">
    <div class="container-md flex items-center justify-between py-3">
        <a class="logo text-2xl text-white" href="/Projects/AuraEdition/index.php">AuraEdition</a>
        <ul class="flex space-x-6 list-none items-center m-0 p-0">
            <li><a class="nav-link text-white hover:text-blue-400 transition" href="/Projects/AuraEdition/index.php">Home</a></li>
        </ul>
        <div class="flex items-center space-x-4">
            <a href="/Projects/AuraEdition/pages/cart.php">
                <i class="bi bi-cart-fill text-2xl"></i>
            </a>

            <!-- Display login or logout button -->
            

        </div>
    </div>
</nav>
<!-- Navigation Bar -->

