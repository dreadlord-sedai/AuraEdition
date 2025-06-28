<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminFunctions.php';

header('Content-Type: application/json');

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserWithAddress($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] != "admin") {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $make_name = trim($_POST['name']);
    if ($make_name === '') {
        echo json_encode(["success" => false, "message" => "Make name cannot be empty."]);
        exit;
    }
    if (addMake($connection, $make_name)) {
        echo json_encode(["success" => true, "message" => "Make added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add make."]);
    }
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}

