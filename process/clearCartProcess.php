<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['vehicles']);
    unset($_SESSION['total_price']);
    echo "success";
    exit;
} else {
    echo "Invalid request method";
    exit;
}
?>
