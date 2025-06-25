<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserInfo($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] !== 'admin') {
    header("Location: /Projects/AuraEdition/index.php");
    exit();
}

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $userId = (int)$_POST['user_id'];
        if (deleteUser($connection, $userId)) {
            $_SESSION['success_message'] = 'User deleted successfully';
        } else {
            $_SESSION['error_message'] = 'Failed to delete user';
        }
    } elseif (isset($_POST['toggle_role'])) {
        $userId = (int)$_POST['user_id'];
        if (toggleUserRole($connection, $userId)) {
            $_SESSION['success_message'] = 'User role updated successfully';
        } else {
            $_SESSION['error_message'] = 'Failed to update user role';
        }
    }
    
    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Get all users
$users = getAllUsers($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Users</title>
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
                <!-- Flash Messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                        <?php unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                        <?php unset($_SESSION['error_message']); ?>
                    </div>
                <?php endif; ?>

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold text-white">Users Management</h3>
                </div>

                <!-- Users Table -->
                <div id="usersTable" class="bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-400">No users found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr class="hover:bg-gray-750">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">
                                                #<?php echo htmlspecialchars($user['id']); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-white">
                                                    <?php echo htmlspecialchars($user['fname'] . ' ' . $user['lname']); ?>
                                                </div>
                                                <?php if (!empty($user['user_date'])): ?>
                                                <div class="text-xs text-gray-400">
                                                    Joined <?php echo date('M d, Y', strtotime($user['user_date'])); ?>
                                                </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                <?php echo htmlspecialchars($user['email']); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    <?php echo $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'; ?>">
                                                    <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                <form method="POST" class="inline">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                    <button type="submit" name="toggle_role" class="px-2 py-1 text-xs font-medium rounded <?php echo $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800 hover:bg-purple-200' : 'bg-blue-100 text-blue-800 hover:bg-blue-200'; ?>">
                                                        Make <?php echo $user['role'] === 'admin' ? 'User' : 'Admin'; ?>
                                                    </button>
                                                </form>
                                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                    <button type="submit" name="delete_user" class="px-2 py-1 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Users Table -->

            </div>
            <!-- Main Content -->

        </div>
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFooter.php'; ?>