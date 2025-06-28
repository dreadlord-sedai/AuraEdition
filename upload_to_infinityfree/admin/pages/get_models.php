<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/admin/includes/adminFunctions.php';

header('Content-Type: application/json');

if (isset($_GET['make_id']) && is_numeric($_GET['make_id'])) {
    $make_id = (int)$_GET['make_id'];
    $models = getModelsByMake($connection, $make_id);
    echo json_encode($models);
} else {
    echo json_encode([]);
} 