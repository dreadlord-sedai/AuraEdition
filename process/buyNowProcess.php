<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Here you would:
        // 1. Get Vehicle details from the database
        // 2. Store in Session
        // Calculate total price
        
        
        // For now, just simulate success:
        echo "success";
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid request method";
    exit;
}
?>