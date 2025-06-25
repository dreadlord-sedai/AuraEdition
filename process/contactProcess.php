<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../includes/PHPMailer/Exception.php';
require_once __DIR__ . '/../includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../includes/PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back with error (customize as needed)
        header('Location: /pages/contact.php?status=error');
        exit();
    }

    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your@email.com'; // SMTP username
        $mail->Password = 'yourpassword';   // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Or PHPMailer::ENCRYPTION_SMTPS
        $mail->Port = 587; // 465 for SMTPS

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('your@email.com', 'Site Admin'); // Your receiving email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form Submission';
        $mail->Body    = "<b>Name:</b> {$name}<br><b>Email:</b> {$email}<br><b>Message:</b><br>" . nl2br(htmlspecialchars($message));
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nMessage:\n{$message}";

        $mail->send();
        header('Location: /pages/contact.php?status=success');
        exit();
    } catch (Exception $e) {
        // Log error or handle as needed
        header('Location: /pages/contact.php?status=error');
        exit();
    }
} else {
    header('Location: /pages/contact.php');
    exit();
}
?>
