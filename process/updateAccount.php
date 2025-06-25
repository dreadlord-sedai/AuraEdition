<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

// Function to handle errors
function handleError($message) {
    $_SESSION['error'] = $message;
    header("Location: /Projects/AuraEdition/pages/account.php");
    exit;
}

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
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $country = trim($_POST['country'] ?? '');

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
        // Verify database connection
        if ($connection->connect_error) {
            throw new Exception("Database connection failed");
        }
        
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

        // Update or insert address
        // Check if address exists
        $checkStmt = $connection->prepare("SELECT address_id FROM user_addresses WHERE address_user_id = ?");
        if (!$checkStmt) {
            throw new Exception("Prepare failed: " . $connection->error);
        }
        
        $checkStmt->bind_param("i", $user_id);
        if (!$checkStmt->execute()) {
            throw new Exception("Execute failed: " . $checkStmt->error);
        }
        
        $addressExists = $checkStmt->get_result()->num_rows > 0;
        $checkStmt->close();
        
        // Use the country from the form
        
        if ($addressExists) {
            // Update existing address

            $stmt = $connection->prepare("UPDATE user_addresses SET address = ?, city = ?, state = ?, country = ? WHERE address_user_id = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $connection->error);
            }
            $stmt->bind_param("ssssi", $address, $city, $state, $country, $user_id);
        } else {
            // Insert new address

            $stmt = $connection->prepare("INSERT INTO user_addresses (address_user_id, address, city, state, country) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $connection->error);
            }
            $stmt->bind_param("issss", $user_id, $address, $city, $state, $country);
        }
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        // Commit transaction
        $connection->commit();
        
        $_SESSION['success'] = "Account updated successfully!";
    } catch (Exception $e) {
        // Rollback transaction on error
        if (isset($connection)) {
            $connection->rollback();
        }
        handleError("An error occurred while updating your account. Please try again.");
    }

    header("Location: /Projects/AuraEdition/pages/account.php");
    exit;
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: /Projects/AuraEdition/pages/account.php");
    exit;
}
