<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUser($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] != "admin") {
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
                <div>
                    <form action="/Projects/AuraEdition/admin/actions/handleAccount.php" method="POST" class="flex flex-col gap-3">
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col gap-2">
                                <label for="name" class="text-light"> First Name</label>
                                <input type="text" name="name" id="name" value="<?php echo $user['fname']; ?>" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>    
                            <div class="flex flex-col gap-2">
                                <label for="name" class="text-light"> Last Name</label>
                                <input type="text" name="name" id="name" value="<?php echo $user['lname']; ?>" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>  
                            <div class="flex flex-col gap-2">
                                <label for="email" class="text-light">Email</label>
                                <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="password" class="text-light">Password</label>
                                <input type="password" name="password" id="password" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="confirm_password" class="text-light">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-primary px-6 py-2">Update Account</button>
                        </div>
                    </form>            
                </div>
                <!-- Account Form -->

                <!-- Address Form -->
                <div>
                    <form action="/Projects/AuraEdition/admin/actions/handleAddress.php" method="POST" class="flex flex-col gap-3">
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col gap-2">
                                <label for="address" class="text-light">Address</label>                        
                                <input type="text" name="address" id="address" value="Address" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="city" class="text-light">City</label>
                                <input type="text" name="city" id="city" value="city" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>  
                            <div class="flex flex-col gap-2">    
                                <label for="state" class="text-light">State</label>
                                <input type="text" name="state" id="state"  value="state" required 
                                class=" w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="country" class="text-light">Country</label>
                                <input type="text" name="country" id="country" value="countyry" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="zip" class="text-light">Zip Code</label>
                                <input type="text" name="zip" id="zip" value="zip" required 
                                class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-primary px-6 py-2">Update Address</button>
                        </div>
                    </form>
                </div>
                <!-- Address Form -->



            </div>
            <!-- Main Content -->

        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>