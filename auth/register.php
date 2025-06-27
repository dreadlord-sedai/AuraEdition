<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';

$Error_message = "";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Register</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <div class="relative w-full h-screen">
        <img src="/Projects/AuraEdition/assets/images/sign.jpg" class="w-full h-screen object-cover" alt="Sign Image">
        <div class="absolute inset-0 flex justify-center items-center bg-black/60">
            <div class="w-full max-w-md">
                <div class="bg-black/80 backdrop-blur-lg shadow-2xl rounded-xl px-8 pt-8 pb-10 border border-yellow-400/30">
                    <h2 class="text-3xl font-serif text-yellow-400 mb-6 text-center tracking-wide" style="font-family: 'Trajan Pro', serif;">Create Your Account</h2>

                    <!-- Display message-->
                    <?php if (isset($_GET['error']) && !empty($_GET['error'])): ?>
                    <div class="mb-4 w-full p-4 rounded text-yellow-400 bg-red-900/80 border border-yellow-400/30 text-center font-semibold shadow">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                    <?php endif; ?>
                    <!-- Display message-->

                    <form action="/Projects/AuraEdition/auth/registerProcess.php" method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="fname" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">First Name</label>
                                <input type="text" id="fname" name="fname" required
                                    class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200">
                            </div>
                            <div>
                                <label for="lname" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Last Name</label>
                                <input type="text" id="lname" name="lname" required
                                    class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200">
                        </div>
                        <div>
                            <label for="password" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200">
                        </div>
                        <div class="flex flex-col gap-3 mt-6">
                            <button type="submit"
                                class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all text-lg tracking-wide shadow">Register</button>
                            <a href="/Projects/AuraEdition/auth/login.php" class="w-full">
                                <button type="button"
                                    class="w-full bg-gray-900 text-yellow-400 border border-yellow-400 rounded-lg hover:bg-yellow-400 hover:text-black transition-all text-lg font-semibold py-3 mt-2 shadow">Login</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>

</body>

</html>