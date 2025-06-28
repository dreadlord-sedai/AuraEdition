<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminFunctions.php';

header('Content-Type: application/json');

if (isset($_GET['make_id']) && is_numeric($_GET['make_id'])) {
    $make_id = (int)$_GET['make_id'];
    $models = getModelsByMake($connection, $make_id);
    echo json_encode($models);
} else {
    echo json_encode([]);
} 
