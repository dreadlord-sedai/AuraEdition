<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Invalid CSRF token.');
        header('Location: reset_password.php?token=' . urlencode($_POST['token'] ?? ''));
        exit;
    }
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    if ($token && $password && $confirm_password) {
        if ($password !== $confirm_password) {
            set_flash('error', 'Passwords do not match.');
            header('Location: reset_password.php?token=' . urlencode($token));
            exit;
        }
        // Validate token
        $stmt = $connection->prepare("SELECT id FROM users WHERE password_reset_token = ? AND password_reset_expires > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $update = $connection->prepare("UPDATE users SET hashed_password = ?, password_reset_token = NULL, password_reset_expires = NULL WHERE id = ?");
            $update->bind_param("si", $hashed, $user_id);
            $update->execute();
            $update->close();
            $stmt->close();
            set_flash('success', 'Password reset successful! You can now log in.');
            header('Location: login.php');
            exit;
        } else {
            $stmt->close();
            set_flash('error', 'Invalid or expired token.');
            header('Location: reset_password.php');
            exit;
        }
    } else {
        set_flash('error', 'Please fill in all fields.');
        header('Location: reset_password.php?token=' . urlencode($token));
        exit;
    }
} else {
    set_flash('error', 'Invalid request.');
    header('Location: reset_password.php');
    exit;
} 
