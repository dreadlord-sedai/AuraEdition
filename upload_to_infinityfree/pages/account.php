<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth_helpers.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit;
}

// Get user data with address
$user_id = $_SESSION['user_id'];
$user = getUserWithAddress($connection, $user_id);

if (!$user) {
    $_SESSION['error'] = 'User not found';
    header("Location: /auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | My Account</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
</head>

<body class="bg-black text-white min-h-screen">
    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto my-12 px-4">
        <div class="bg-gray-900 rounded-xl shadow-lg border border-yellow-400/20 overflow-hidden">
            <!-- Account Header -->
            <div class="px-6 py-6 bg-black border-b-2 border-yellow-400/20">
                <h2 class="text-3xl font-serif text-yellow-400 flex items-center gap-2" style="font-family: 'Trajan Pro', serif;">
                    <i class="fas fa-user-circle text-yellow-400 text-3xl"></i>
                    My Account
                </h2>
            </div>

            <!-- Messages -->
            <div class="px-6 pt-4">
                <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/flash_messages.php'; ?>
            </div>

            <!-- Account Form -->
            <div class="p-8">
                <div id="formErrors" class="mb-4"></div>
                <form id="accountForm" action="/process/updateAccount.php" method="POST" class="space-y-8">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generate_csrf_token()) ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label for="fname" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">First Name</label>
                                <input type="text" name="fname" id="fname" value="<?= htmlspecialchars($user['fname'] ?? '') ?>" 
                                    class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                    required>
                            </div>
                            <div>
                                <label for="lname" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Last Name</label>
                                <input type="text" name="lname" id="lname" value="<?= htmlspecialchars($user['lname'] ?? '') ?>" 
                                    class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                    required>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label for="email" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                                        class="block w-full pl-10 px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Update Section -->
                    <div class="pt-8 border-t-2 border-yellow-400/20">
                        <h3 class="text-xl font-serif text-yellow-400 mb-4" style="font-family: 'Trajan Pro', serif;">Change Password</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div>
                                    <label for="current_password" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Current Password</label>
                                    <input type="password" name="current_password" id="current_password" 
                                        class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                        placeholder="Enter current password">
                                </div>
                                <div>
                                    <label for="new_password" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">New Password</label>
                                    <input type="password" name="new_password" id="new_password" 
                                        class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                        placeholder="Enter new password">
                                </div>
                                <div>
                                    <label for="confirm_password" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Confirm New Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" 
                                        class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                        placeholder="Confirm new password">
                                </div>
                            </div>
                            <div class="text-sm text-gray-400">
                                <p class="mb-2">Password requirements:</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>At least 8 characters</li>
                                    <li>At least one uppercase letter</li>
                                    <li>At least one number</li>
                                    <li>At least one special character</li>
                                </ul>
                                <p class="mt-4">Leave password fields blank to keep your current password.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div class="pt-8 border-t-2 border-yellow-400/20">
                        <h3 class="text-xl font-serif text-yellow-400 mb-4" style="font-family: 'Trajan Pro', serif;">Address Information</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="address" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Street Address</label>
                                <input type="text" name="address" id="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" 
                                    class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                    placeholder="Enter your street address">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="country" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">Country</label>
                                    <input type="text" name="country" id="country" value="<?= htmlspecialchars($user['country'] ?? '') ?>" 
                                        class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                        placeholder="Enter your country">
                                </div>
                                <div>
                                    <label for="city" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">City</label>
                                    <input type="text" name="city" id="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>" 
                                        class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                        placeholder="City">
                                </div>
                                <div>
                                    <label for="state" class="block text-yellow-400 font-serif mb-2" style="font-family: 'Trajan Pro', serif;">State</label>
                                    <input type="text" name="state" id="state" value="<?= htmlspecialchars($user['state'] ?? '') ?>" 
                                        class="w-full px-4 py-3 bg-black border border-gray-700 text-white rounded-lg focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200"
                                        placeholder="State">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t-2 border-yellow-400/20">
                        <div class="flex justify-end">
                            <button type="submit" name="update_account" 
                                class="px-8 py-3 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition-all text-lg tracking-wide">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Main Content -->

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>
</body>
</html>
