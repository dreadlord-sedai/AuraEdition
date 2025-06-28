<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminFunctions.php';

$current_user = authorize_admin($connection);

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $userId = (int)$_POST['user_id'];
        if ($userId === $current_user['id']) {
            set_flash('error', 'You cannot delete your own account.');
        } elseif (deleteUser($connection, $userId)) {
            set_flash('success', 'User deleted successfully.');
        } else {
            set_flash('error', 'Failed to delete user.');
        }
    } elseif (isset($_POST['toggle_role'])) {
        $userId = (int)$_POST['user_id'];
        if ($userId === $current_user['id']) {
            set_flash('error', 'You cannot change your own role.');
        } elseif (toggleUserRole($connection, $userId)) {
            set_flash('success', 'User role updated successfully.');
        } else {
            set_flash('error', 'Failed to update user role.');
        }
    }
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}
// Pagination & Filtering
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$offset = ($page - 1) * $items_per_page;
$search = $_GET['search'] ?? '';
$role = $_GET['role'] ?? '';
$total_users = countAllUsers($connection, $search, $role);
$total_pages = ceil($total_users / $items_per_page);
$users = getAllUsers($connection, $search, $role, $items_per_page, $offset);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Manage Users</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminHeader.php'; ?>
</head>

<body class="bg-gray-900 text-gray-100">
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminSidebar.php'; ?>
    <div class="ml-64 flex-1 flex flex-col">
        <?php 
            $breadcrumbs = ['Users' => '/admin/pages/users.php'];
            include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminNavbar.php'; 
        ?>
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-yellow-400" style="font-family: 'Trajan Pro', serif;">Manage Users</h1>
            </div>

            <?php if ($msg = get_flash('success')): ?>
                <div class="mb-6 p-4 bg-green-900/80 border border-green-700 text-green-300 rounded-lg shadow-lg font-semibold"><?= htmlspecialchars($msg) ?></div>
            <?php elseif ($msg = get_flash('error')): ?>
                <div class="mb-6 p-4 bg-red-900/80 border border-red-700 text-red-300 rounded-lg shadow-lg font-semibold"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <div class="bg-black border border-gray-800 rounded-2xl p-6 mb-8">
                <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-semibold text-gray-400 mb-2">Search Users</label>
                        <input type="text" name="search" id="search" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400" placeholder="By name or email..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-400 mb-2">Filter by Role</label>
                        <select name="role" id="role" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400">
                            <option value="">All Roles</option>
                            <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all">Filter</button>
                    </div>
                </form>
            </div>

            <div class="bg-black border border-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-700 bg-gray-900/50">
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">User</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Role</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr class="border-b border-gray-800 hover:bg-gray-900">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-white"><?= htmlspecialchars($user['fname'] . ' ' . $user['lname']) ?></div>
                                    <div class="text-sm text-gray-400"><?= htmlspecialchars($user['email']) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full border <?= $user['role'] === 'admin' ? 'bg-purple-900 text-purple-300 border-purple-700' : 'bg-blue-900 text-blue-300 border-blue-700' ?>">
                                        <?= ucfirst(htmlspecialchars($user['role'])) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($current_user['id'] !== $user['id']): ?>
                                    <form method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to toggle the role for this user?');">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" name="toggle_role" class="font-semibold text-yellow-400 hover:text-yellow-300 mr-4">Toggle Role</button>
                                    </form>
                                    <form method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" name="delete_user" class="font-semibold text-red-500 hover:text-red-400">Delete</button>
                                    </form>
                                    <?php else: ?>
                                    <span class="text-gray-500 italic">Current User</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($total_pages > 1): ?>
                <div class="flex justify-between items-center mt-6 px-6 py-4 bg-black border-t border-gray-800">
                    <div class="text-sm text-gray-400">
                        Showing <span class="font-semibold text-white"><?= $offset + 1 ?></span> to <span class="font-semibold text-white"><?= min($offset + $items_per_page, $total_users) ?></span> of <span class="font-semibold text-white"><?= $total_users ?></span> results
                    </div>
                    <div class="flex items-center">
                        <?php
                        $query_params = http_build_query(array_filter(['search' => $search, 'role' => $role]));
                        $base_url = "/admin/pages/users.php?" . $query_params;
                        if ($page > 1) echo '<a href="' . $base_url . '&page=' . ($page - 1) . '" class="px-4 py-2 mx-1 bg-gray-800 text-gray-300 rounded-lg hover:bg-gray-700">Previous</a>';
                        if ($page < $total_pages) echo '<a href="' . $base_url . '&page=' . ($page + 1) . '" class="px-4 py-2 mx-1 bg-gray-800 text-gray-300 rounded-lg hover:bg-gray-700">Next</a>';
                        ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>
