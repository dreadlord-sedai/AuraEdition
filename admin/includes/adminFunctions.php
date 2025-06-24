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

function updateAccount($connection, $user_id, $fname, $lname, $email, $password)
{
    $sql = "UPDATE users SET fname = ?, lname = ?, email = ?";
    $types = "sss";
    $params = [$fname, $lname, $email];

    if (!empty($password)) {
        $sql .= ", hashed_password = ?";
        $types .= "s";
        $params[] = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql .= " WHERE id = ?";
    $types .= "i";
    $params[] = $user_id;

    $stmt = $connection->prepare($sql);
    if (!$stmt) return;
    $stmt->bind_param($types, ...$params);
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


/* Display Functions */
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

function getVehicles($connection, $search, $status, $priceSort)
{
    $query = "SELECT * FROM vehicles";
    $whereClauses = [];
    $params = [];
    $types = '';

    if (!empty($search)) {
        $whereClauses[] = "title LIKE ?";
        $params[] = "%" . $search . "%";
        $types .= 's';
    }

    if (!empty($status)) {
        $whereClauses[] = "status = ?";
        $params[] = $status;
        $types .= 's';
    }

    if (!empty($whereClauses)) {
        $query .= " WHERE " . implode(" AND ", $whereClauses);
    }

    if ($priceSort === 'low') {
        $query .= " ORDER BY price ASC";
    } elseif ($priceSort === 'high') {
        $query .= " ORDER BY price DESC";
    }

    $stmt = $connection->prepare($query);
    if (!$stmt) return [];

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $vehicles = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $vehicles;
}


function getAllOrders($connection)
{
    $stmt = $connection->prepare("SELECT * FROM orders");
    if (!$stmt) return null;
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $orders;
}


/* Display Functions */


/* Product Functions */
function updateProduct($connection, $product_id, $title, $description, $price, $quantity, $category)
{
    $stmt = $connection->prepare("UPDATE vehicles SET title = ?, description = ?, price = ?, quantity = ?, category = ? WHERE id = ?");
    if (!$stmt) return null;
    $stmt->bind_param("ssdsssi", $title, $description, $price, $quantity, $category, $product_id);
    $stmt->execute();
    $stmt->close();
}
/* Product Functions */