<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

/* Account Functions */

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

function updateAccount($connection, $user_id, $fname, $lname, $email, $confirm_password)
{
    $hashedPassword = password_hash($confirm_password, PASSWORD_DEFAULT);
    $stmt = $connection->prepare("UPDATE users SET fname = ?, lname = ?, email = ?, hashed_password = ? WHERE id = ?");
    if (!$stmt) return null;
    $stmt->bind_param("ssssi", $fname, $lname, $email, $hashedPassword, $user_id);
    $stmt->execute();
    $stmt->close();
}

/* Account Functions */

