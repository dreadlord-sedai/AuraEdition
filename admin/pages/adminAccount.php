<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserInfo($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] !== 'admin') {
    header("Location: /Projects/AuraEdition/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Admin Account</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminHeader.php'; ?>
</head>

<body class="bg-black">
    <div class="flex">
        <!-- Sidebar -->
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminSidebar.php'; ?>

        <!-- Main Content Area -->
        <div class="flex-1 min-h-screen flex flex-col">
            <!-- Navigation Bar -->
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminNavbar.php'; ?>
            <!-- Main Content -->
            <div class="p-8 flex flex-col">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-2xl font-semibold mb-4 text-light">Account</h3>
                    
                </div>

                <!-- Account Form -->
                 <?php 
                 if (isset($_SESSION['success'])) {
                     echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                     unset($_SESSION['success']);
                 }
                 if (isset($_SESSION['error'])) {
                     echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                     unset($_SESSION['error']);
                 }

                 ?>
                <div>
                    <form action="/Projects/AuraEdition/admin/actions/handleAccount.php" method="POST" class="flex flex-col gap-3">
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col gap-2">
                                <label for="fname" class="text-light"> First Name</label>
                                <input type="text" name="fname" id="fname" value="<?= htmlspecialchars($user['fname'] ?? '') ?>" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>    
                            <div class="flex flex-col gap-2">
                                <label for="lname" class="text-light"> Last Name</label>
                                <input type="text" name="lname" id="lname" value="<?= htmlspecialchars($user['lname'] ?? '') ?>" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>  
                            <div class="flex flex-col gap-2">
                                <label for="email" class="text-light">Email</label>
                                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="password" class="text-light">New Password (leave blank to keep current)</label>
                                <input type="password" name="password" id="password" placeholder="Enter new password"
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="confirm_password" class="text-light">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password"
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" name="update_account" class="btn btn-primary px-6 py-2">Update Account</button>
                        </div>
                    </form>            
                </div>
                <!-- Account Form -->

                <!-- Address Form -->
                <div class="mt-8">
                    <h3 class="text-2xl font-semibold mb-4 text-light">Address</h3>
                    <form action="/Projects/AuraEdition/admin/actions/handleAddress.php" method="POST" class="flex flex-col gap-3">
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col gap-2">
                                <label for="address" class="text-light">Address</label>                        
                                <input type="text" name="address" id="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="city" class="text-light">City</label>
                                <input type="text" name="city" id="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>" 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>  
                            <div class="flex flex-col gap-2">    
                                <label for="state" class="text-light">State</label>
                                <input type="text" name="state" id="state"  value="<?= htmlspecialchars($user['state'] ?? '') ?>" 
                                class=" w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="zip" class="text-light">Zip Code</label>
                                <input type="text" name="zip" id="zip" value="<?= htmlspecialchars($user['zip'] ?? '') ?>" 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" name="update_address" class="btn btn-primary px-6 py-2">Update Address</button>
                        </div>
                    </form>
                </div>
                <!-- Address Form -->



            </div>
            <!-- Main Content -->

        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>