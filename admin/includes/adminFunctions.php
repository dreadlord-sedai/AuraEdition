<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

function getUserInfo($connection, $user_id)
{
    $stmt = $connection->prepare("SELECT
    u.id,
    u.fname,
    u.lname,
    u.email,
    u.role,
    ua.address,
    ua.city,
    ua.state
FROM users u
LEFT JOIN user_addresses ua ON u.id = ua.address_user_id
WHERE u.id = ?");
    if (!$stmt) return null;
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user;
}
