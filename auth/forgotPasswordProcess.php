<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../includes/PHPMailer/Exception.php';
require_once __DIR__ . '/../includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../includes/PHPMailer/SMTP.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
// If you have PHPMailer setup, include it here
// include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/PHPMailer/PHPMailerAutoload.php';

date_default_timezone_set('Asia/Colombo'); // or your preferred timezone

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $connection->prepare("SELECT id, fname FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $fname);
            $stmt->fetch();
            $token = bin2hex(random_bytes(32));

            $update = $connection->prepare(
                "UPDATE users SET password_reset_token = ?, password_reset_expires = (NOW() + INTERVAL 1 HOUR) WHERE id = ?"
            );
            $update->bind_param("si", $token, $user_id);
            $update->execute();
            $update->close();

            // Send email using PHPMailer
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/Projects/AuraEdition/auth/reset_password.php?token=$token";
            
            $mail = new PHPMailer(true);
            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'dahamigaveshna@gmail.com';
                $mail->Password = 'doylgwtzypdmphwt';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('dahamigaveshna@gmail.com', 'AuraEdition Support');
                $mail->addAddress($email, $fname);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your AuraEdition Password Reset Link';
                $mail->Body    = "<div style='font-family: Arial, sans-serif; color: #333;'>
                                    <h2 style='color: #c0a062;'>AuraEdition Password Reset</h2>
                                    <p>Dear {$fname},</p>
                                    <p>We received a request to reset your password. Click the link below to set a new one:</p>
                                    <p style='margin: 20px 0;'><a href='{$reset_link}' style='background-color: #c0a062; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Your Password</a></p>
                                    <p>This link is valid for one hour. If you did not request a password reset, please ignore this email.</p>
                                    <p>Best Regards,<br>The AuraEdition Team</p>
                                  </div>";
                $mail->AltBody = "To reset your password, visit this link: {$reset_link}. This link is valid for 1 hour.";

                $mail->send();
            } catch (Exception $e) {
                // Log the error for debugging, but don't show it to the user.
                error_log("PHPMailer Error: " . $mail->ErrorInfo);
            }
        }
        $stmt->close();
    }
    // Always show a generic success message for security
    header("Location: forgot_password.php?success=If your email exists, a reset link has been sent.");
    exit;
} else {
    header("Location: forgot_password.php?error=Invalid request.");
    exit;
} 