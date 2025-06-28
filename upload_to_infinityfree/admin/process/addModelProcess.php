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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && !empty($_POST['make_id'])) {
    $model_name = trim($_POST['name']);
    $make_id = $_POST['make_id'];
    if ($model_name === '') {
        echo json_encode(["success" => false, "message" => "Model name cannot be empty."]);
        exit;
    }
    if (addModel($connection, $model_name, $make_id)) {
        echo json_encode(["success" => true, "message" => "Model added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add model."]);
    }
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}
