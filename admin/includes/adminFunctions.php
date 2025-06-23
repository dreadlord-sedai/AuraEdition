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

function updateAddress($connection, $user_id, $address, $city, $state)
{
    $stmt = $connection->prepare("UPDATE user_addresses SET address = ?, city = ?, state = ?  WHERE address_user_id = ?");
    if (!$stmt) return null;
    $stmt->bind_param("sssi", $address, $city, $state, $user_id);
    $stmt->execute();
    $stmt->close();
}


/* Account Functions */


function getRecentOrders($connection)
{   
    $stmt = $connection->prepare("SELECT * FROM orders ORDER BY orderd_at DESC LIMIT 5");
    if (!$stmt) return null;
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $orders;
}

function getVehicles($connection, $search, $status, $price)
{
    $query = "SELECT * FROM vehicles";  

    if ($search) {
        $query .= " WHERE title LIKE '%$search%'";
    }
    if ($status) {
        $query .= " WHERE status = '$status'";
    }
    if ($price) {
        $query .= " WHERE price = '$price'";
    }
    $stmt = $connection->prepare($query);
    if (!$stmt) return null;
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicles = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $vehicles;
}

