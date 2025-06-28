<!-- Sidebar -->
<div class="fixed top-0 left-0 h-full w-64 bg-black text-white p-6 flex flex-col justify-between shadow-2xl border-r border-gray-800">
    <div>
        <!-- Logo -->
        <div class="mb-12 text-center">
            <a href="/admin/dashboard.php" class="text-3xl font-serif text-yellow-400 tracking-wider" style="font-family: 'Trajan Pro', serif;">AURA</a>
            <p class="text-xs text-gray-500 uppercase tracking-widest">Admin Panel</p>
    </div>

        <!-- Navigation Links -->
        <nav class="flex flex-col space-y-3">
            <a href="/admin/dashboard.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-900 hover:text-yellow-400 rounded-lg transition-all duration-200">
                <i class="fas fa-tachometer-alt w-6 text-center"></i>
                <span class="ml-4 font-semibold">Dashboard</span>
            </a>
            <a href="/admin/pages/vehicles.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-900 hover:text-yellow-400 rounded-lg transition-all duration-200">
                <i class="fas fa-car w-6 text-center"></i>
                <span class="ml-4 font-semibold">Vehicles</span>
            </a>
            <a href="/admin/pages/categories.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-900 hover:text-yellow-400 rounded-lg transition-all duration-200">
                <i class="fas fa-sitemap w-6 text-center"></i>
                <span class="ml-4 font-semibold">Makes</span>
            </a>
            <a href="/admin/pages/orders.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-900 hover:text-yellow-400 rounded-lg transition-all duration-200">
                <i class="fas fa-receipt w-6 text-center"></i>
                <span class="ml-4 font-semibold">Orders</span>
            </a>
            <a href="/admin/pages/users.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-900 hover:text-yellow-400 rounded-lg transition-all duration-200">
                <i class="fas fa-users w-6 text-center"></i>
                <span class="ml-4 font-semibold">Users</span>
            </a>
        </nav>
    </div>

    <!-- Admin Account Link -->
    <div class="border-t border-gray-800 pt-6">
        <a href="/admin/pages/adminAccount.php" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-900 hover:text-yellow-400 rounded-lg transition-all duration-200">
            <i class="fas fa-user-shield w-6 text-center"></i>
            <span class="ml-4 font-semibold">Admin Account</span>
        </a>
    </div>
</div>

<!-- Dummy div to offset content -->
<div class="w-64 flex-shrink-0"></div>
