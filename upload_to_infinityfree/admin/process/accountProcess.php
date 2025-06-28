<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminFunctions.php';

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserWithAddress($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] !== 'admin') {
    header("Location: /index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!verify_csrf_token($_POST['csrf_token'])) {
        set_flash('error', 'Invalid request. Please try again.');
        header('Location: /admin/pages/adminAccount.php');
        exit;
    }
    
    $user_id = $_SESSION['user_id'];

    // Update Account Details
    if (isset($_POST['update_account'])) {
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($fname) || empty($lname) || empty($email)) {
            set_flash('error', 'First name, last name, and email are required.');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            set_flash('error', 'Invalid email format.');
        } elseif (!empty($password) && $password !== $confirm_password) {
            set_flash('error', 'Passwords do not match.');
        } else {
            updateAccount($connection, $user_id, $fname, $lname, $email, $password);
            set_flash('success', 'Account details updated successfully.');
        }
    }

    // Update Address
    if (isset($_POST['update_address'])) {
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $state = trim($_POST['state']);

        updateAddress($connection, $user_id, $address, $city, $state);
        set_flash('success', 'Address updated successfully.');
    }

    header('Location: /admin/pages/adminAccount.php');
    exit;
} else {
    header('Location: /admin/pages/adminAccount.php');
    exit;
} 
