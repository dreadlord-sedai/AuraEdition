<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Invalid CSRF token.');
        header('Location: login.php');
        exit;
    }
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            set_flash('error', 'Invalid email format.');
            header('Location: login.php');
            exit;
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
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $id;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['lname'] = $lname;
                    $_SESSION['email'] = $db_email;
                    $_SESSION['role'] = $role;

                    $select_user_query->close();
                    // Redirect to the home page after successful login
                    header("Location: /index.php");
                    exit;
                } else {
                    set_flash('error', 'Incorrect email or password.');
                    $select_user_query->close();
                    header('Location: login.php');
                    exit;
                }
            } else {
                set_flash('error', 'Incorrect email or password.');
                $select_user_query->close();
                header('Location: login.php');
                exit;
            }
        }
    } else {
        set_flash('error', 'Please fill in all fields.');
        header('Location: login.php');
        exit;
    }
}
