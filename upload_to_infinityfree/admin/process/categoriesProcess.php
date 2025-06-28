<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

$user = authorize_admin($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_make'])) {
        $make_name = trim($_POST['make_name']);
        if (!empty($make_name)) {
            addMake($connection, $make_name);
            set_flash('success', 'Make added successfully.');
        } else {
            set_flash('error', 'Make name cannot be empty.');
        }
    } elseif (isset($_POST['add_model'])) {
        $model_name = trim($_POST['model_name']);
        $make_id = (int)$_POST['make_id'];
        if (!empty($model_name) && !empty($make_id)) {
            addModel($connection, $model_name, $make_id);
            set_flash('success', 'Model added successfully.');
        } else {
            set_flash('error', 'Model name and make are required.');
        }
    } elseif (isset($_POST['delete_make'])) {
        $make_id = (int)$_POST['make_id'];
        deleteMake($connection, $make_id);
        set_flash('success', 'Make deleted successfully.');
    } elseif (isset($_POST['delete_model'])) {
        $model_id = (int)$_POST['model_id'];
        deleteModel($connection, $model_id);
        set_flash('success', 'Model deleted successfully.');
    }       
    header("Location: " . BASE_URL . "/admin/pages/categories.php");
    exit();
}

// ... existing code ... 