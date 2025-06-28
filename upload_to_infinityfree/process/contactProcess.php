<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../includes/PHPMailer/Exception.php';
require_once __DIR__ . '/../includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../includes/PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $name = trim($first_name . ' ' . $last_name);
    $email = trim($_POST['_replyto'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back with error (customize as needed)
        header('Location: /pages/contact.php?status=error');
        exit();
    }

    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'dahamigaveshna@gmail.com'; // SMTP username
        $mail->Password = 'doylgwtzypdmphwt';   // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Or PHPMailer::ENCRYPTION_SMTPS
        $mail->Port = 587; // 465 for SMTPS

        // Recipients
        $mail->setFrom('dahamigaveshna@gmail.com', $name); // Use your Gmail as sender
        $mail->addReplyTo($email, $name); // User's email as reply-to
        $mail->addAddress('dahamifabbio@gmail.com', 'Site Admin'); // Your receiving email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form Submission';
        $mail->Body    = "<b>Name:</b> {$name}<br><b>Email:</b> {$email}<br><b>Message:</b><br>" . nl2br(htmlspecialchars($message));
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nMessage:\n{$message}";

        $mail->send();
        header('Location: /pages/contact.php?status=success');
        exit();
    } catch (Exception $e) {
        // Show PHPMailer error for debugging
        echo '<h3 style="color:red;">Mailer Error: ' . htmlspecialchars($mail->ErrorInfo) . '</h3>';
        exit();
    }
} else {
    header('Location: Projects/AuraEdition/pages/contact.php');
    exit();
}
?>
