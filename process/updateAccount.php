<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /Projects/AuraEdition/auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    // Get form data
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip_code = trim($_POST['zip_code'] ?? '');

    // Basic validation
    if (empty($fname) || empty($lname) || empty($email)) {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: /Projects/AuraEdition/pages/account.php");
        exit;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
        header("Location: /Projects/AuraEdition/pages/account.php");
        exit;
    }

    // Check if email already exists
    $stmt = $connection->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['error'] = "Email already in use by another account.";
        header("Location: /Projects/AuraEdition/pages/account.php");
        exit;
    }

    // Handle password change if requested
    if (!empty($new_password)) {
        // Verify current password if changing password
        $stmt = $connection->prepare("SELECT hashed_password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if (!password_verify($current_password, $user['hashed_password'])) {
            $_SESSION['error'] = "Current password is incorrect.";
            header("Location: /Projects/AuraEdition/pages/account.php");
            exit;
        }

        // Validate new password
        if (strlen($new_password) < 8 || 
            !preg_match("/[A-Z]/", $new_password) || 
            !preg_match("/[0-9]/", $new_password) || 
            !preg_match("/[^A-Za-z0-9]/", $new_password)) {
            $_SESSION['error'] = "New password must be at least 8 characters long and include uppercase, number and special character.";
            header("Location: /Projects/AuraEdition/pages/account.php");
            exit;
        }

        if ($new_password !== $confirm_password) {
            $_SESSION['error'] = "New passwords do not match.";
            header("Location: /Projects/AuraEdition/pages/account.php");
            exit;
        }
    }

    // Start transaction
    $connection->begin_transaction();
    
    try {
        // Update user table
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $connection->prepare("UPDATE users SET fname = ?, lname = ?, email = ?, phone = ?, hashed_password = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $fname, $lname, $email, $phone, $hashed_password, $user_id);
        } else {
            $stmt = $connection->prepare("UPDATE users SET fname = ?, lname = ?, email = ?, phone = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $fname, $lname, $email, $phone, $user_id);
        }
        $stmt->execute();

        // Update or insert address
        $stmt = $connection->prepare("SELECT address_user_id FROM user_addresses WHERE address_user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows > 0) {
            // Update existing address
            $stmt = $connection->prepare("UPDATE user_addresses SET address = ?, city = ?, state = ?, zip_code = ? WHERE address_user_id = ?");
            $stmt->bind_param("ssssi", $address, $city, $state, $zip_code, $user_id);
        } else {
            // Insert new address
            $stmt = $connection->prepare("INSERT INTO user_addresses (address_user_id, address, city, state, zip_code) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $user_id, $address, $city, $state, $zip_code);
        }
        $stmt->execute();

        // Commit transaction
        $connection->commit();
        
        $_SESSION['success'] = "Account updated successfully!";
    } catch (Exception $e) {
        // Rollback transaction on error
        $connection->rollback();
        $_SESSION['error'] = "An error occurred while updating your account. Please try again.";
        error_log("Update account error: " . $e->getMessage());
    }

    header("Location: /Projects/AuraEdition/pages/account.php");
    exit;
} else {
    header("Location: /Projects/AuraEdition/pages/account.php");
    exit;
}
