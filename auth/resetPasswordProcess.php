<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    if ($token && $password && $confirm_password) {
        if ($password !== $confirm_password) {
            header("Location: reset_password.php?token=" . urlencode($token) . "&error=Passwords do not match.");
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
            header("Location: login.php?password_reset=1");
            exit;
        } else {
            $stmt->close();
            header("Location: reset_password.php?error=Invalid or expired token.");
            exit;
        }
    } else {
        header("Location: reset_password.php?error=Please fill in all fields.");
        exit;
    }
} else {
    header("Location: reset_password.php?error=Invalid request.");
    exit;
} 