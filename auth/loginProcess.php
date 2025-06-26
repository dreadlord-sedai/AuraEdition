<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';


    if ($email && $password) {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $Error_message = "Invalid email format.";
        } else {
            // Prepare a statement to select user by email
            $select_user_query = $connection->prepare(
                "SELECT id, fname, lname, email, hashed_password, role FROM users WHERE email = ?"
            );
            $select_user_query->bind_param("s", $email);
            $select_user_query->execute();
            $select_user_query->store_result();


            if ($select_user_query->num_rows > 0) {

                $select_user_query->bind_result($id, $fname, $lname, $db_email, $hashed_password, $role);
                $select_user_query->fetch();

                // Verify the password using password_verify
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['lname'] = $lname;
                    $_SESSION['email'] = $db_email;
                    $_SESSION['role'] = $role;

                    $select_user_query->close();
                    // Redirect to the home page after successful login
                    header("Location: /Projects/AuraEdition/index.php");
                    exit;
                } else {
                    // Password is incorrect
                    $Error_message = "Incorrect password. Please try again.";
                }
            } else {
                // No user found with this email
                $Error_message = "Email not found. Please register first.";
            }
            $select_user_query->close();
        }
    } else {
        // One or both fields are empty
        $Error_message = "Please fill in all fields.";
    }
}