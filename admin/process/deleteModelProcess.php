<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

header('Content-Type: application/json');

// Check if user is logged in and is admin
$user = isset($_SESSION['user_id']) ? getUserWithAddress($connection, $_SESSION['user_id']) : null;
if (!$user || $user['role'] != "admin") {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $model_id = (int)$_POST['id'];
    if (deleteModel($connection, $model_id)) {
        echo json_encode(["success" => true, "message" => "Model deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete model."]);
    }
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}
