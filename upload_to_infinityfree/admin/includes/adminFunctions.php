<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

/* Account Functions */

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

/**
 * Ensures the current user is an authenticated admin.
 *
 * This function checks for a valid admin session. If the user is not an
 * admin, it redirects them to the main site index and terminates script execution.
 * It also returns the user's info if the check passes, simplifying variable assignment.
 *
 * @param mysqli $connection The database connection object.
 * @return array The user's information array.
 */
function authorize_admin($connection) {
    $user = isset($_SESSION['user_id']) ? getUserWithAddress($connection, $_SESSION['user_id']) : null;
    if (!$user || $user['role'] !== 'admin') {
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }
    return $user;
}

/* Account Functions */


/* Display Functions */
function getRecentOrders($connection)
{
    $stmt = $connection->prepare("
        SELECT o.*, u.fname, u.lname 
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.orderd_at DESC 
        LIMIT 5
    ");
    if (!$stmt) return [];
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $orders;
}

function getVehicles($connection, $search, $status, $priceSort)
{
    $query = "SELECT v.id, v.title, v.status, v.price, v.stock, m.make_name as make_name 
              FROM vehicles v 
              LEFT JOIN makes m ON v.make_id = m.make_id";
    $whereClauses = [];
    $params = [];
    $types = '';

    if (!empty($search)) {
        $whereClauses[] = "(v.title LIKE ? OR m.make_name LIKE ?)";
        $params[] = "%" . $search . "%";
        $params[] = "%" . $search . "%";
        $types .= 'ss';
    }

    if (!empty($status)) {
        $whereClauses[] = "v.status = ?";
        $params[] = $status;
        $types .= 's';
    }

    if (!empty($whereClauses)) {
        $query .= " WHERE " . implode(" AND ", $whereClauses);
    }

    if ($priceSort === 'low') {
        $query .= " ORDER BY v.price ASC";
    } elseif ($priceSort === 'high') {
        $query .= " ORDER BY v.price DESC";
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


function getAllOrders($connection, $search, $status, $limit, $offset)
{
    $query = "SELECT o.*, u.fname, u.lname 
              FROM orders o
              JOIN users u ON o.user_id = u.id";
    $whereClauses = [];
    $params = [];
    $types = '';

    if (!empty($search)) {
        $whereClauses[] = "(o.order_id LIKE ? OR u.fname LIKE ? OR u.lname LIKE ? OR u.email LIKE ?)";
        $searchTerm = "%" . $search . "%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        $types .= 'ssss';
    }

    if (!empty($status)) {
        $whereClauses[] = "o.status = ?";
        $params[] = $status;
        $types .= 's';
    }

    if (!empty($whereClauses)) {
        $query .= " WHERE " . implode(" AND ", $whereClauses);
    }

    $query .= " ORDER BY o.orderd_at DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= 'ii';

    $stmt = $connection->prepare($query);
    if (!$stmt) return [];

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $orders;
}

function countAllOrders($connection, $search, $status)
{
    $query = "SELECT COUNT(*) as total
              FROM orders o
              JOIN users u ON o.user_id = u.id";
    $whereClauses = [];
    $params = [];
    $types = '';

    if (!empty($search)) {
        $whereClauses[] = "(o.order_id LIKE ? OR u.fname LIKE ? OR u.lname LIKE ? OR u.email LIKE ?)";
        $searchTerm = "%" . $search . "%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        $types .= 'ssss';
    }

    if (!empty($status)) {
        $whereClauses[] = "o.status = ?";
        $params[] = $status;
        $types .= 's';
    }

    if (!empty($whereClauses)) {
        $query .= " WHERE " . implode(" AND ", $whereClauses);
    }

    $stmt = $connection->prepare($query);
    if (!$stmt) return 0;

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result['total'] ?? 0;
}

function getTotalListings($connection) {
    $result = $connection->query("SELECT COUNT(*) as total FROM vehicles");
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

function getTotalOrders($connection) {
    $result = $connection->query("SELECT COUNT(*) as total FROM orders");
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

function getTotalUsers($connection) {
    $result = $connection->query("SELECT COUNT(*) as total FROM users");
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

function getTotalRevenue($connection) {
    $result = $connection->query("SELECT SUM(total_price) as total_revenue FROM orders");
    $row = $result->fetch_assoc();
    return $row['total_revenue'] ?? 0;
}

function getSalesDataForChart($connection) {
    $query = "SELECT 
                DATE_FORMAT(orderd_at, '%Y-%m') as month, 
                SUM(total_price) as total_sales
              FROM orders
              WHERE orderd_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
              GROUP BY month
              ORDER BY month ASC";
    
    $result = $connection->query($query);
    if (!$result) return ['labels' => [], 'data' => []];

    $labels = [];
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $date = new DateTime($row['month'] . '-01');
        $labels[] = $date->format('M Y');
        $data[] = (float)$row['total_sales'];
    }

    return ['labels' => $labels, 'data' => $data];
}

/* Display Functions */


/* Product Functions */

function addProduct($connection, $title, $description, $price, $stock, $make, $model)
{
    $stmt = $connection->prepare("INSERT INTO vehicles (title, description, price, stock, make_id, model_id) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) return null;
    $stmt->bind_param("ssdiii", $title, $description, $price, $stock, $make, $model);
    $stmt->execute();
    $stmt->close();
}

function uploadProductImage($file, $product_id, $connection) {
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = '/products/img/';
            $newFileName = uniqid('product_' . $product_id . '_', true) . '.' . $fileExtension;
            $dest_path = $_SERVER['DOCUMENT_ROOT'] . $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagePath = $uploadFileDir . $newFileName;
                $stmt = $connection->prepare("INSERT INTO vehicle_images (image_vehicle_id, image_path) VALUES (?, ?)");
                if ($stmt) {
                    $stmt->bind_param("is", $product_id, $imagePath);
                    $stmt->execute();
                    $stmt->close();
                }
                return $imagePath; // Success
            }
        }
    }
    return false; // Failure
}
function getProductInfo($connection, $product_id)
{
    $stmt = $connection->prepare("SELECT 
    v.id,
    v.title,
    v.description,
    v.price,
    v.stock,
    v.status,
    v.make_id,
    v.model_id,
    m.make_name,
    mo.model_name
    FROM vehicles v
    LEFT JOIN makes m ON v.make_id = m.make_id
    LEFT JOIN model mo ON v.model_id = mo.model_id
    WHERE v.id = ?");
    if (!$stmt) return null;
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    return $product;
}

function getModelsByMake($connection, $make_id)
{
    $stmt = $connection->prepare("SELECT model_name, model_id FROM model WHERE model_make_id = ?");
    if (!$stmt) return [];
    $stmt->bind_param("i", $make_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $models = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $models;

    
}

function updateProduct($connection, $product_id, $title, $description, $price, $stock, $make, $model)
{
    $stmt = $connection->prepare("UPDATE vehicles SET title = ?, description = ?, price = ?, stock = ?, make_id = ?, model_id = ? WHERE id = ?");
    if (!$stmt) return null;
    $stmt->bind_param("ssdiiii", $title, $description, $price, $stock, $make, $model, $product_id);
    $stmt->execute();
    $stmt->close();
}

function updateProductImage($file, $product_id, $connection) {
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = '/products/img/';
            $newFileName = uniqid('product_' . $product_id . '_', true) . '.' . $fileExtension;
            $dest_path = $_SERVER['DOCUMENT_ROOT'] . $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Update the image path in the database (vehicles table assumed)
                $imagePath = $uploadFileDir . $newFileName;
                $stmt = $connection->prepare("UPDATE vehicle_images SET image_path = ? WHERE image_vehicle_id = ?");
                if ($stmt) {
                    $stmt->bind_param("si", $imagePath, $product_id);
                    $stmt->execute();
                    $stmt->close();
                }
                return $imagePath; // Success
            }
        }
    }
    return false; // Failure
}

function deleteProduct($connection, $product_id)
{
    $stmt = $connection->prepare("DELETE FROM vehicles WHERE id = ?");
    if (!$stmt) return null;
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();
}

function deleteProductImage($connection, $product_id)
{
    $stmt = $connection->prepare("DELETE FROM vehicle_images WHERE image_vehicle_id = ?");
    if (!$stmt) return null;
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();
}


/* Product Functions */


/* Category Functions */

function getAllModels($connection)
{
    $stmt = $connection->prepare("SELECT 
    mo.model_id,
    mo.model_name,
    m.make_name
    FROM model mo
    LEFT JOIN makes m ON mo.model_make_id = m.make_id");    
    if (!$stmt) return null;
    $stmt->execute();
    $result = $stmt->get_result();
    $models = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $models;
}

/* Category Functions */



/* Admin User Management Functions */
function getAllUsers($connection, $search, $role, $limit, $offset) {
    $sql = "SELECT u.id, u.fname, u.lname, u.email, u.role, u.registerd_date as user_date
            FROM users u";
    
    $whereClauses = [];
    $params = [];
    $types = '';

    if (!empty($search)) {
        $whereClauses[] = "(u.fname LIKE ? OR u.lname LIKE ? OR u.email LIKE ?)";
        $searchTerm = "%" . $search . "%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
        $types .= 'sss';
    }

    if (!empty($role)) {
        $whereClauses[] = "u.role = ?";
        $params[] = $role;
        $types .= 's';
    }

    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    $sql .= " ORDER BY u.registerd_date DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= 'ii';

    $stmt = $connection->prepare($sql);
    if (!$stmt) return [];
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $users;
}

function countAllUsers($connection, $search, $role) {
    $sql = "SELECT COUNT(*) as total FROM users u";

    $whereClauses = [];
    $params = [];
    $types = '';

    if (!empty($search)) {
        $whereClauses[] = "(u.fname LIKE ? OR u.lname LIKE ? OR u.email LIKE ?)";
        $searchTerm = "%" . $search . "%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
        $types .= 'sss';
    }

    if (!empty($role)) {
        $whereClauses[] = "u.role = ?";
        $params[] = $role;
        $types .= 's';
    }

    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    $stmt = $connection->prepare($sql);
    if (!$stmt) return 0;
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result['total'] ?? 0;
}

function deleteUser($connection, $userId) {
    $connection->begin_transaction();
    
    try {
        // Delete from user_addresses first (due to foreign key constraint)
        $stmt1 = $connection->prepare("DELETE FROM user_addresses WHERE address_user_id = ?");
        $stmt1->bind_param("i", $userId);
        $stmt1->execute();
        
        // Then delete the user
        $stmt2 = $connection->prepare("DELETE FROM users WHERE id = ?");
        $stmt2->bind_param("i", $userId);
        $stmt2->execute();
        
        $connection->commit();
        return true;
    } catch (Exception $e) {
        $connection->rollback();
        error_log("Error deleting user: " . $e->getMessage());
        return false;
    }
}

function toggleUserRole($connection, $userId) {
    // First check if the role column exists
    $checkColumn = $connection->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($checkColumn->num_rows === 0) {
        return false; // Role column doesn't exist
    }
    
    // Get current role
    $stmt = $connection->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return false; // User not found
    }
    
    $user = $result->fetch_assoc();
    $newRole = ($user['role'] === 'admin') ? 'user' : 'admin';
    
    // Update role
    $updateStmt = $connection->prepare("UPDATE users SET role = ? WHERE id = ?");
    $updateStmt->bind_param("si", $newRole, $userId);
    $success = $updateStmt->execute();
    
    return $success;
}

/* Admin User Management Functions */
