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
if (isset($_POST['update_account'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $confirm_password = $_POST['confirm_password'];

    // Update account information in the database
    updateAccount($connection, $user['id'], $fname, $lname, $email, $confirm_password);

    // Redirect back to the admin account page
    header("Location: /Projects/AuraEdition/admin/pages/adminAccount.php");
    exit;
}