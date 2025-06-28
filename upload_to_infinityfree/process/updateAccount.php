<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /Projects/AuraEdition/auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Invalid CSRF token. Please try again.');
        header("Location: /Projects/AuraEdition/pages/account.php");
        exit;
    }
    // Get form data
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $country = trim($_POST['country'] ?? '');

    // Basic validation
    if (empty($fname) || empty($lname) || empty($email)) {
        set_flash('error', "Please fill in all required fields.");
        header("Location: /Projects/AuraEdition/pages/account.php");
        exit;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash('error', "Please enter a valid email address.");
        header("Location: /Projects/AuraEdition/pages/account.php");
        exit;
    }

    // Check if email already exists for another user
    $stmt = $connection->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        set_flash('error', "Email already in use by another account.");
        header("Location: /Projects/AuraEdition/pages/account.php");
        exit;
    }
    $stmt->close();

    // Handle password change if requested
    if (!empty($new_password)) {
        // Verify current password if changing password
        $stmt = $connection->prepare("SELECT hashed_password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if (!password_verify($current_password, $user['hashed_password'])) {
            set_flash('error', "Current password is incorrect.");
            header("Location: /Projects/AuraEdition/pages/account.php");
            exit;
        }

        // Validate new password
        if (strlen($new_password) < 8 || 
            !preg_match("/[A-Z]/", $new_password) || 
            !preg_match("/[0-9]/", $new_password) || 
            !preg_match("/[^A-Za-z0-9]/", $new_password)) {
            set_flash('error', "New password must be at least 8 characters long and include uppercase, number and special character.");
            header("Location: /Projects/AuraEdition/pages/account.php");
            exit;
        }

        if ($new_password !== $confirm_password) {
            set_flash('error', "New passwords do not match.");
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
            $stmt = $connection->prepare("UPDATE users SET fname = ?, lname = ?, email = ?, hashed_password = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $fname, $lname, $email, $hashed_password, $user_id);
        } else {
            $stmt = $connection->prepare("UPDATE users SET fname = ?, lname = ?, email = ? WHERE id = ?");
            $stmt->bind_param("sssi", $fname, $lname, $email, $user_id);
        }
        $stmt->execute();
        $stmt->close();

        // Update session with new name/email
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;
        $_SESSION['email'] = $email;

        // Update or insert address
        $checkStmt = $connection->prepare("SELECT address_id FROM user_addresses WHERE address_user_id = ?");
        $checkStmt->bind_param("i", $user_id);
        $checkStmt->execute();
        $addressExists = $checkStmt->get_result()->num_rows > 0;
        $checkStmt->close();
        
        if (empty($address) && empty($city) && empty($state) && empty($country)) {
            // If all address fields are empty, do nothing or delete existing address if desired
        } else {
            if ($addressExists) {
                // Update existing address
                $stmt = $connection->prepare("UPDATE user_addresses SET address = ?, city = ?, state = ?, country = ? WHERE address_user_id = ?");
                $stmt->bind_param("ssssi", $address, $city, $state, $country, $user_id);
            } else {
                // Insert new address
                $stmt = $connection->prepare("INSERT INTO user_addresses (address_user_id, address, city, state, country) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $user_id, $address, $city, $state, $country);
            }
            $stmt->execute();
            $stmt->close();
        }
        // Commit transaction
        $connection->commit();
        
        set_flash('success', "Account updated successfully!");
    } catch (Exception $e) {
        $connection->rollback();
        // Log the actual error for debugging
        error_log('Account update failed: ' . $e->getMessage());
        set_flash('error', "An error occurred while updating your account. Please try again.");
    }
    header("Location: /Projects/AuraEdition/pages/account.php");
    exit;
} else {
    set_flash('error', "Invalid request method.");
    header("Location: /Projects/AuraEdition/pages/account.php");
    exit;
}
