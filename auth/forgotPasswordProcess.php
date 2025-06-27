<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
// If you have PHPMailer setup, include it here
// include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/PHPMailer/PHPMailerAutoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if ($email) {
        $stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $update = $connection->prepare("UPDATE users SET password_reset_token = ?, password_reset_expires = ? WHERE id = ?");
            $update->bind_param("ssi", $token, $expires, $user_id);
            $update->execute();
            $update->close();
            // Send email
            $reset_link = "https://" . $_SERVER['HTTP_HOST'] . "/Projects/AuraEdition/auth/reset_password.php?token=$token";
            $subject = "AuraEdition Password Reset";
            $body = "Click the link to reset your password: <a href='$reset_link'>$reset_link</a> (valid for 1 hour)";
            // Use your mail function or PHPMailer here
            mail($email, $subject, $body, "Content-type: text/html; charset=UTF-8");
        }
        $stmt->close();
    }
    // Always show a generic message for security
    header("Location: forgot_password.php?success=If your email exists, a reset link has been sent.");
    exit;
} else {
    header("Location: forgot_password.php?error=Invalid request.");
    exit;
} 