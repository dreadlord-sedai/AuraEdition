<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!--Sidebar-->
<div id="adminSidebar" class="h-screen w-64 bg-gray-900 text-white flex flex-col py-8 px-6">
    <!-- Panel Title -->
    <div class="mb-10">
        <span class="text-2xl font-semibold tracking-wide">Admin Panel</span>
    </div>
    <!-- Navigation -->
    <nav class="flex flex-col gap-2">
        <a href="/Projects/AuraEdition/admin/dashboard.php"
            class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium focus:outline-none transition hover:bg-gray-700 
            text-decoration-none <?= $currentPage == 'dashboard.php' ? 'bg-gray-800' : '' ?>">
            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 
                1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
            </svg>
            Dashboard
        </a>
        <a href="/Projects/AuraEdition/admin/pages/vehicles.php"
            class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium focus:outline-none transition hover:bg-gray-700 
            text-decoration-none <?= $currentPage == 'vehicles.php' ? 'bg-gray-800' : '' ?>">
            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 
                00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4" />
            </svg>
            Vehicles
        </a>
        <a href="/Projects/AuraEdition/admin/pages/orders.php"
            class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium focus:outline-none transition hover:bg-gray-700 
            text-decoration-none <?= $currentPage == 'orders.php' ? 'bg-gray-800' : '' ?>">
            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 
                2v2m-6 4h6a2 2 0 002-2v-5a2 2 0 00-2-2h-6a2 2 0 00-2 2v5a2 2 0 002 2z" />
            </svg>
            Orders
        </a>
        <a href="/Projects/AuraEdition/admin/pages/addProduct.php"
            class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium focus:outline-none transition hover:bg-gray-700 
            text-decoration-none <?= $currentPage == 'addProduct.php' ? 'bg-gray-800' : '' ?>">
            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Products
        </a>
        <a href="/Projects/AuraEdition/admin/pages/categories.php"
            class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium focus:outline-none transition hover:bg-gray-700 
            text-decoration-none <?= $currentPage == 'categories.php' ? 'bg-gray-800' : '' ?>">
            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6 2C3.79086 2 2 3.79086 2 6V7C2 9.20914 3.79086 11 6 11H7C9.20914 11 11 9.20914 11 7V6C11 3.79086 9.20914 2 7 2H6ZM17 2C14.7909 2 13 3.79086 13 6V7C13 9.20914 14.7909 11 17 11H18C20.2091 11 22 9.20914 22 7V6C22 3.79086 20.2091 2 18 2H17ZM6 13C3.79086 13 2 14.7909 2 17V18C2 20.2091 3.79086 22 6 22H7C9.20914 22 11 20.2091 11 18V17C11 14.7909 9.20914 13 7 13H6ZM17 13C14.7909 13 13 14.7909 13 17V18C13 20.2091 14.7909 22 17 22H18C20.2091 22 22 20.2091 22 18V17C22 14.7909 20.2091 13 18 13H17Z" fill="#000000">
                </path>
            </svg>
            Categories

        </a>
    </nav>
</div>
<!--Sidebar-->