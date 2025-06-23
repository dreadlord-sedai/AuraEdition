<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';


$user = isset($_SESSION['user_id']) ? getUserInfo($connection, $_SESSION['user_id']) : null;
if (!$user) {
    header("Location: /Projects/AuraEdition/index.php");
    exit;
}



// Check if user is logged in
if (isset($_POST['update_address'])) {
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];

    // Update account information in the database
    updateAddress($connection, $user['id'], $address, $city, $state,);

    // Redirect back to the admin account page
    header("Location: /Projects/AuraEdition/admin/pages/adminAccount.php");
    exit;
}