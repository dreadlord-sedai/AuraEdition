<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserWithAddress($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] != "admin") {
    header("Location: /Projects/AuraEdition/index.php");
    exit;
}

// Process the form submission for adding a make
if (isset($_POST['name']) && !empty($_POST['make_id'])) {
    $model_name = $_POST['name'];
    $make_id = $_POST['make_id'];

    addModel($connection, $model_name, $make_id);
    echo "success";
    exit;
  
}
