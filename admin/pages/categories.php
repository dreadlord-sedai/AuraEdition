<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

$user = authorize_admin($connection);

// Get all makes and models
$makes = getAllMakes($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Manage Makes & Models</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminHeader.php'; ?>
</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Sidebar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminSidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="ml-64 flex-1 flex flex-col">
        <!-- Navigation Bar -->
        <?php 
            $breadcrumbs = ['Makes & Models' => '/Projects/AuraEdition/admin/pages/categories.php'];
            include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminNavbar.php'; 
        ?>
        
        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Makes Section -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-6" style="font-family: 'Trajan Pro', serif;">Manage Makes</h2>
                    <!-- Add Make Form -->
                    <div class="bg-black border border-gray-800 rounded-2xl p-6 mb-8">
                        <form onsubmit="return addMake(event)" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div class="md:col-span-2">
                                <label for="make_name" class="block text-sm font-semibold text-gray-400 mb-2">Make Name</label>
                                <input type="text" name="make_name" id="make_name" placeholder="e.g., Rolls-Royce" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all shadow-md">Add Make</button>
                            </div>
                        </form>
                    </div>

                    <!-- Makes Table -->
                    <div class="bg-black border border-gray-800 rounded-2xl shadow-lg overflow-hidden">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-700 bg-gray-900/50">
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">ID</th>
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Name</th>
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($makes as $make):
                                ?>
                                <tr class="border-b border-gray-800 hover:bg-gray-900 transition-colors">
                                    <td class='px-6 py-4 font-mono text-gray-300'><?= htmlspecialchars($make['make_id']) ?></td>
                                    <td class='px-6 py-4 font-semibold text-white'><?= htmlspecialchars($make['make_name']) ?></td>
                                    <td class='px-6 py-4 text-center'>
                                        <a href="javascript:void(0)" onclick="deleteMake(<?= $make['make_id'] ?>)" class='text-red-500 hover:text-red-400 font-semibold'>Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Models Section -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-6" style="font-family: 'Trajan Pro', serif;">Manage Models</h2>
                    <!-- Add Model Form -->
                    <div class="bg-black border border-gray-800 rounded-2xl p-6 mb-8">
                        <form method="POST" onsubmit="return addModel(event)" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div class="md:col-span-2">
                                <label for="model_name" class="block text-sm font-semibold text-gray-400 mb-2">Model Name</label>
                                <input type="text" name="model_name" id="model_name" placeholder="e.g., Phantom" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                            </div>
                             <div>
                                <label for="make_id" class="block text-sm font-semibold text-gray-400 mb-2">Assign to Make</label>
                                <select name="make_id" id="make_id" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                                    <option value="">Select Make</option>
                                    <?php foreach ($makes as $make): ?>
                                        <option value="<?= htmlspecialchars($make['make_id']) ?>"><?= htmlspecialchars($make['make_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                             </div>
                            <div>
                                <button type="submit" name="add_model" class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-lg hover:bg-yellow-500 transition-all shadow-md">Add Model</button>
                            </div>
                        </form>
                    </div>

                    <!-- Models Table -->
                    <div class="bg-black border border-gray-800 rounded-2xl shadow-lg overflow-hidden">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-700 bg-gray-900/50">
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">ID</th>
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Model Name</th>
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase">Make</th>
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-300 uppercase text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $models = getAllModels($connection);
                                foreach ($models as $model):
                                ?>
                                <tr class="border-b border-gray-800 hover:bg-gray-900 transition-colors">
                                    <td class='px-6 py-4 font-mono text-gray-300'><?= htmlspecialchars($model['model_id']) ?></td>
                                    <td class='px-6 py-4 font-semibold text-white'><?= htmlspecialchars($model['model_name']) ?></td>
                                    <td class='px-6 py-4 text-gray-300'><?= htmlspecialchars($model['make_name']) ?></td>
                                    <td class='px-6 py-4 text-center'>
                                        <a href="javascript:void(0)"  onclick="deleteModel(<?= $model['model_id'] ?>)" class='text-red-500 hover:text-red-400 font-semibold'>Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function addMake(event) {
            event.preventDefault();
            const makeName = document.getElementById('make_name').value;
            if (!makeName) return;
            // You can use Fetch API to send this to a handler
            console.log('Adding make:', makeName);
            // Example: window.location.href = `/Projects/AuraEdition/admin/process/handleCategory.php?action=add_make&name=${makeName}`;
            alert('Add functionality not yet connected.');
        }

        function deleteMake(id) {
            if (confirm('Are you sure you want to delete this make? This might affect existing vehicles.')) {
                // Example: window.location.href = `/Projects/AuraEdition/admin/process/handleCategory.php?action=delete_make&id=${id}`;
                alert('Delete functionality not yet connected.');
            }
        }

        function addModel(event) {
            event.preventDefault();
            const modelName = document.getElementById('model_name').value;
            const makeId = document.getElementById('make_id').value;
            if (!modelName || !makeId) return;
            console.log(`Adding model: ${modelName} to make ID: ${makeId}`);
            alert('Add functionality not yet connected.');
        }

        function deleteModel(id) {
            if (confirm('Are you sure you want to delete this model?')) {
                alert('Delete functionality not yet connected.');
            }
        }
    </script>
</body>

</html>