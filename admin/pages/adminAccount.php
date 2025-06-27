<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserInfo($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] !== 'admin') {
    header("Location: /Projects/AuraEdition/index.php");
    exit;
}
// Generate CSRF token
generate_csrf_token();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Admin Account</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminHeader.php'; ?>
</head>

<body class="bg-gray-900 text-gray-100">
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminSidebar.php'; ?>
    <div class="ml-64 flex-1 flex flex-col">
        <?php 
            $breadcrumbs = ['Account' => '/Projects/AuraEdition/admin/pages/adminAccount.php'];
            include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminNavbar.php'; 
        ?>
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-yellow-400" style="font-family: 'Trajan Pro', serif;">My Account</h1>
            </div>

            <?php if ($msg = get_flash('success')): ?>
                <div class="mb-6 p-4 bg-green-900/80 border border-green-700 text-green-300 rounded-lg shadow-lg"><?= htmlspecialchars($msg) ?></div>
            <?php elseif ($msg = get_flash('error')): ?>
                <div class="mb-6 p-4 bg-red-900/80 border border-red-700 text-red-300 rounded-lg shadow-lg"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <div class="bg-black border border-gray-800 rounded-2xl p-8 shadow-lg">
                <form action="/Projects/AuraEdition/admin/process/accountProcess.php" method="POST" class="space-y-8">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        <!-- Account Details Section -->
                        <div class="space-y-6">
                            <h2 class="text-2xl font-semibold text-yellow-400 border-b-2 border-gray-800 pb-3" style="font-family: 'Trajan Pro', serif;">Profile</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="fname" class="block text-sm font-semibold text-gray-400 mb-2">First Name</label>
                                    <input type="text" name="fname" id="fname" value="<?= htmlspecialchars($user['fname'] ?? '') ?>" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                                    <label for="lname" class="block text-sm font-semibold text-gray-400 mb-2">Last Name</label>
                                    <input type="text" name="lname" id="lname" value="<?= htmlspecialchars($user['lname'] ?? '') ?>" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                            </div>  
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-400 mb-2">Email Address</label>
                                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                            </div>
                            <div class="pt-4 border-t border-gray-800">
                                <button type="submit" name="update_account" class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all shadow-md">Update Profile</button>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="space-y-6">
                             <h2 class="text-2xl font-semibold text-yellow-400 border-b-2 border-gray-800 pb-3" style="font-family: 'Trajan Pro', serif;">Security</h2>
                             <div>
                                <label for="password" class="block text-sm font-semibold text-gray-400 mb-2">New Password</label>
                                <input type="password" name="password" id="password" placeholder="Leave blank to keep current" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                            </div>
                            <div>
                                <label for="confirm_password" class="block text-sm font-semibold text-gray-400 mb-2">Confirm New Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                            </div>  
                             <div class="pt-4 border-t border-gray-800">
                                <button type="submit" name="update_account" class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all shadow-md">Update Password</button>
                            </div>
                        </div>
                        </div>
                    </form>
            </div>
        </main>
    </div>
</body>
</html>