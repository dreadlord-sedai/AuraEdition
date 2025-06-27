<!-- Main navigation bar -->
<header class="bg-black border-b border-gray-800 shadow-md">
    <div class="flex items-center justify-between px-8 py-4">
        <!-- Breadcrumbs can be dynamically generated here if needed -->
        <div class="text-gray-400">
            <a href="/Projects/AuraEdition/admin/dashboard.php" class="hover:text-yellow-400">Admin</a>
            <span class="mx-2">/</span>
            <span class="text-white font-semibold">Dashboard</span>
        </div>

        <!-- User profile dropdown -->
        <div class="relative">
            <button id="user-menu-button" class="flex items-center focus:outline-none">
                <span class="text-white font-semibold mr-3"><?= htmlspecialchars($user['fname'] ?? 'Admin') ?></span>
                <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center">
                    <span class="text-black font-bold text-lg"><?= htmlspecialchars(strtoupper(substr($user['fname'] ?? 'A', 0, 1))) ?></span>
                </div>
                <i class="fas fa-chevron-down text-white ml-2"></i>
            </button>

            <!-- Dropdown menu -->
            <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-black border border-gray-800 rounded-lg shadow-xl py-2 z-50">
                <a href="/Projects/AuraEdition/admin/pages/adminAccount.php" class="block px-4 py-2 text-gray-300 hover:bg-gray-900 hover:text-yellow-400">My Account</a>
                <a href="/Projects/AuraEdition/auth/logout.php" class="block px-4 py-2 text-gray-300 hover:bg-gray-900 hover:text-yellow-400">Sign Out</a>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        if(userMenuButton) {
            userMenuButton.addEventListener('click', function () {
                userMenu.classList.toggle('hidden');
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (userMenu && !userMenu.classList.contains('hidden') && !userMenuButton.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    });
</script>