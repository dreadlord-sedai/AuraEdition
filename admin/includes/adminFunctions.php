<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

function getUser($connection, $user_id) {
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = $connection->query($query);
    return $result->fetch_assoc();
}