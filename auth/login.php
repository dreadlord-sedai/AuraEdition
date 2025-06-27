<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/auth_helpers.php';

$Error_message = "";
$Success_message = "";

// If redirected from registration, show a success message
if (isset($_GET['registered']) && $_GET['registered'] == 1) {
    $Success_message = "Registration successful! You can now log in.";
}
// If redirected from password reset, show a success message
if (isset($_GET['password_reset']) && $_GET['password_reset'] == 1) {
    $Success_message = "Password reset successful! You can now log in.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Login</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>
</head>

<body>
    <div class="relative w-full h-screen">
        <!-- Background image -->
        <img src="/Projects/AuraEdition/assets/images/sign.jpg" class="w-full h-screen object-cover" alt="Sign Image">

        <!-- Centered login card -->
        <div class="absolute inset-0 flex justify-center items-center bg-black/60">
            <div class="w-full max-w-md">
                <div class="bg-black/80 backdrop-blur-lg shadow-2xl rounded-xl px-8 pt-8 pb-10 border border-yellow-400/30">
                    <h2 class="text-3xl font-serif text-yellow-400 mb-6 text-center tracking-wide" style="font-family: 'Trajan Pro', serif;">Login</h2>

                    <!-- Display error message if any -->
                    <?php if ($msg = get_flash('error')): ?>
                        <div class="mb-4 text-center text-yellow-400 font-semibold bg-red-900/80 border border-yellow-400/30 rounded px-2 py-2 shadow">
                            <?= htmlspecialchars($msg) ?>
                        </div>
                    <?php elseif ($msg = get_flash('success')): ?>
                        <div class="mb-4 text-center text-green-300 font-semibold bg-green-900/80 border border-yellow-400/30 rounded px-2 py-2 shadow">
                            <?= htmlspecialchars($msg) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login form -->
                    <form action="/Projects/AuraEdition/auth/loginProcess.php" method="POST" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generate_csrf_token()) ?>">
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
                        <div class="mb-6 text-right">
                            <a href="/Projects/AuraEdition/auth/forgot_password.php"
                                class="text-yellow-400 hover:text-yellow-300 text-sm font-semibold transition">Forgot your password?</a>
                        </div>
                        <div class="flex flex-col gap-3 mt-6">
                            <button type="submit"
                                class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all text-lg tracking-wide shadow">Login</button>
                            <a href="/Projects/AuraEdition/auth/register.php" class="w-full">
                                <button type="button"
                                    class="w-full bg-gray-900 text-yellow-400 border border-yellow-400 rounded-lg hover:bg-yellow-400 hover:text-black transition-all text-lg font-semibold py-3 mt-2 shadow">Register</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>
</body>

</html>