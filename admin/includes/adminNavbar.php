<!-- Navigation Bar -->
<nav class="w-full bg-black text-white">

    <div class=" flex flex-row w-full items-center justify-between py-3 px-5">
        <div class="flex items-center gap-3 flex-row">

            <!-- sidebar button -->
            <div>
                
            </div>

            <!-- Logo -->
            <a class="logo text-2xl text-white" href="/Projects/AuraEdition/index.php">AuraEdition</a>

            <div>
                <!-- Account button AND PIC -->
                <div class="flex items-center gap-3">
                    <!-- Account Picture (round) -->
                    <div class="w-15 h-15 rounded-full  flex items-center justify-center overflow-hidden
                    border-3 bg-gray-800 border-gray-600 ">
                        <img src="/Projects/AuraEdition/admin/assets/images/account.jpg" alt="Account" class="w-full h-full object-cover" />
                    </div>
                    <!-- Account Link -->
                    <a href="/Projects/AuraEdition/admin/pages/account.php" class="text-white text-decoration-none hover:text-blue-400
                     font-semibold transition">
                        Account
                    </a>
                </div>
            </div>

        </div>


        <div class="flex items-center">
            <ul class="flex space-x-6 list-none items-center m-0 p-0">
                <li><a class="nav-link text-white hover:text-blue-400 transition" href="/Projects/AuraEdition/index.php">Home</a></li>
            </ul>

            <!-- Display logout button -->
            <div class="text-decoration-none text-white ml-10">
                <button type="button" onclick="logout()"
                    class="border border-red-500 text-red-500 px-4 py-1 rounded
                         hover:bg-red-500 hover:text-white transition d-flex align-items-center">
                    Logout
                </button>
            </div>
        </div>

    </div>

</nav>
<!-- Navigation Bar -->