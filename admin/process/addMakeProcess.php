<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserInfo($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] != "admin") {
    header("Location: /Projects/AuraEdition/index.php");
    exit;
}

if (isset($_POST['name'])) {
    $make_name = $_POST['name'];
    addMake($connection, $make_name);
    echo "success";
    exit;
}

