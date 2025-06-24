<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserInfo($connection, $_SESSION['user_id']) : null;
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
    <title>AuraEdition | Categories</title>
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
                    <h3 class="text-2xl font-semibold mb-4 text-light">Categories</h3>
                </div>

                <!-- Makes Section -->

                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-2xl font-semibold mb-2 text-light">Vehicle Makes</h4>
                    <a href="/Projects/AuraEdition/admin/pages/addMake.php" class="btn btn-primary">Add Make</a>
                </div>
                 
                <div class="bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-2xl mx-auto border border-gray-700">
                    <table class="w-full text-left text-gray-300">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Make ID</th>
                                <th class="px-4 py-2">Make Name</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $makes = getAllMakes($connection);
                            foreach ($makes as $make) {
                                echo "<tr>";
                                echo "<td class='px-4 py-2'>" . htmlspecialchars($make['make_id']) . "</td>";
                                echo "<td class='px-4 py-2'>" . htmlspecialchars($make['make_name']) . "</td>";
                                echo "<td class='px-4 py-2'>
                                        <a href='/Projects/AuraEdition/admin/pages/editMake.php?id=" . htmlspecialchars($make['make_id']) . "' class='text-blue-500 hover:underline'>Edit</a> |
                                        <a href='/Projects/AuraEdition/admin/process/deleteMakeProcess.php?id=" . htmlspecialchars($make['make_id']) . "' class='text-red-500 hover:underline'>Delete</a>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                </div>
                <!-- Makes Section -->

                <!-- Models Section -->
                <div class="mt-10">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-2xl font-semibold mb-2 text-light">Vehicle Models</h4>
                        <a href="/Projects/AuraEdition/admin/pages/addModel.php" class="btn btn-primary">Add Model</a>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-2xl mx-auto border border-gray-700">
                        <table class="w-full text-left text-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Model ID</th>
                                    <th class="px-4 py-2">Model Name</th>
                                    <th class="px-4 py-2">Make Name</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $models = getAllModels($connection);
                                foreach ($models as $model) {
                                    echo "<tr>";
                                    echo "<td class='px-4 py-2'>" . htmlspecialchars($model['model_id']) . "</td>";
                                    echo "<td class='px-4 py-2'>" . htmlspecialchars($model['model_name']) . "</td>";
                                    echo "<td class='px-4 py-2'>" . htmlspecialchars($model['make_name']) . "</td>";
                                    echo "<td class='px-4 py-2'>
                                            <a href='/Projects/AuraEdition/admin/pages/editModel.php?id=" . htmlspecialchars($model['model_id']) . "' class='text-blue-500 hover:underline'>Edit</a> |
                                            <a href='/Projects/AuraEdition/admin/process/deleteModelProcess.php?id=" . htmlspecialchars($model['model_id']) . "' class='text-red-500 hover:underline'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>



            </div>
            <!-- Main Content -->

        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>