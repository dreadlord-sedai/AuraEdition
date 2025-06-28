<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Invalid CSRF token.');
        header('Location: register.php');
        exit;
    }
    // Get the form data and trim whitespace
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate input
    if ($fname && $lname && $email && $password) {
        // Password validation: min 8 chars, at least 1 uppercase, 1 number, 1 special char
        if (strlen($password) < 8 || 
            !preg_match("/[A-Z]/", $password) || 
            !preg_match("/[0-9]/", $password) || 
            !preg_match("/[^A-Za-z0-9]/", $password)) {
            set_flash('error', 'Password must be at least 8 characters long and include an uppercase letter, a number, and a special character.');
            header('Location: register.php');
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            set_flash('error', 'Invalid email format.');
            header('Location: register.php');
            exit;
        } else {
            // Prepare and execute the SQL statement to check if the email already exists
            $select_user_id = $connection->prepare("SELECT id FROM users WHERE email = ?");
            $select_user_id->bind_param("s", $email);
            $select_user_id->execute();
            $select_user_id->store_result();

            if ($select_user_id->num_rows > 0) {
                set_flash('error', 'Email already exists. Please choose a different email.');
                $select_user_id->close();
                header('Location: register.php');
                exit;
            } else {
                // Email does not exist, proceed with registration
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $register_user_query = $connection->prepare("INSERT INTO users (fname, lname, email, hashed_password,registerd_date) VALUES (?, ?, ?, ?, NOW())");
                $register_user_query->bind_param("ssss", $fname, $lname, $email, $hashed_password);
                if ($register_user_query->execute()) {
                    $register_user_query->close();
                    set_flash('success', 'Registration successful! You can now log in.');
                    header('Location: login.php');
                    exit;
                } else {
                    set_flash('error', 'Registration failed. Please try again.');
                    $register_user_query->close();
                    header('Location: register.php');
                    exit;
                }
            }
        }
    } else {
        set_flash('error', 'Please fill in all fields.');
        header('Location: register.php');
        exit;
    }
}