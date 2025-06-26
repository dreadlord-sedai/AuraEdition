<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and trim whitespace
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate input
    if ($fname && $lname && $email && $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $Error_message = "Invalid email format.";
            header("Location: /Projects/AuraEdition/auth/register.php?error=" . urlencode($Error_message));
            exit;
        } else {
            // Prepare and execute the SQL statement to check if the email already exists
            $select_user_id = $connection->prepare("SELECT id FROM users WHERE email = ?");
            $select_user_id->bind_param("s", $email);
            $select_user_id->execute();
            $select_user_id->store_result();

            if ($select_user_id->num_rows > 0) {
                $Error_message = "Email already exists. Please choose a different email.";
                $select_user_id->close();
                header("Location: /Projects/AuraEdition/auth/register.php?error=" . urlencode($Error_message));
                exit;
            } else {
                // Email does not exist, proceed with registration
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $register_user_query = $connection->prepare("INSERT INTO users (fname, lname, email, hashed_password,registerd_date) VALUES (?, ?, ?, ?, NOW())");
                $register_user_query->bind_param("ssss", $fname, $lname, $email, $hashed_password);
                if ($register_user_query->execute()) {
                    $register_user_query->close();
                    header("Location: /Projects/AuraEdition/auth/login.php?registered=1");
                    exit;
                } else {
                    $Error_message = "Registration failed. Please try again.";
                    $register_user_query->close();
                    header("Location: /Projects/AuraEdition/auth/register.php?error=" . urlencode($Error_message));
                    exit;
                }
            }
            $select_user_id->close();
        }
    } else {
        $Error_message = "Please fill in all fields.";
        header("Location: /Projects/AuraEdition/auth/register.php?error=" . urlencode($Error_message));
        exit;
    }
}