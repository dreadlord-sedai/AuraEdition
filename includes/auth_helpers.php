<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

// CSRF Token
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Flash Messaging
function set_flash($type, $message) {
    $_SESSION['flash'][$type] = $message;
}
function get_flash($type) {
    if (isset($_SESSION['flash'][$type])) {
        $msg = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $msg;
    }
    return null;
}

// Secure Random Token
function generate_token($length = 32) {
    return bin2hex(random_bytes($length));
}

// Secure Email Sending (PHPMailer)
function send_email($to, $toName, $subject, $body, $altBody = '') {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = getenv('SMTP_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USER');
        $mail->Password = getenv('SMTP_PASS');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = getenv('SMTP_PORT') ?: 587;
        $mail->setFrom(getenv('SMTP_FROM'), getenv('SMTP_FROM_NAME'));
        $mail->addAddress($to, $toName);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $altBody;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('PHPMailer Error: ' . $mail->ErrorInfo);
        return false;
    }
} 