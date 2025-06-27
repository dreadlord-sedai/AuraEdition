<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/auth_helpers.php';
$token = $_GET['token'] ?? '';
$valid = false;
if ($token) {
    $stmt = $connection->prepare("SELECT id FROM users WHERE password_reset_token = ? AND password_reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
    $valid = $stmt->num_rows > 0;
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Reset Password</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>
</head>
<body>
    <div class="relative w-full h-screen">
        <img src="/Projects/AuraEdition/assets/images/sign.jpg" class="w-full h-screen object-cover" alt="Sign Image">
        <div class="absolute inset-0 flex justify-center items-center bg-black/60">
            <div class="w-full max-w-md">
                <div class="bg-black/80 backdrop-blur-lg shadow-2xl rounded-xl px-8 pt-8 pb-10 border border-yellow-400/30">
                    <h2 class="text-3xl font-serif text-yellow-400 mb-6 text-center tracking-wide" style="font-family: 'Trajan Pro', serif;">Reset Password</h2>
                    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/flash_messages.php'; ?>
                    <?php if ($valid): ?>
                    <form action="/Projects/AuraEdition/auth/resetPasswordProcess.php" method="POST" class="space-y-6">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generate_csrf_token()) ?>">
                        <div>
                            <label for="password" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">New Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200">
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required
                                class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200">
                        </div>
                        <div class="flex flex-col gap-3 mt-6">
                            <button type="submit"
                                class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all text-lg tracking-wide shadow">Reset Password</button>
                            <a href="/Projects/AuraEdition/auth/login.php" class="w-full">
                                <button type="button"
                                    class="w-full bg-gray-900 text-yellow-400 border border-yellow-400 rounded-lg hover:bg-yellow-400 hover:text-black transition-all text-lg font-semibold py-3 mt-2 shadow">Back to Login</button>
                            </a>
                        </div>
                    </form>
                    <?php else: ?>
                        <div class="text-center text-yellow-400 font-semibold">This reset link is invalid or has expired.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>
</body>
</html> 