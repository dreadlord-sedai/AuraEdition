<?php
function get_featured_vehicles($connection, $limit = 3)
{
    // Fetch featured vehicles
    $featured = 1;
    $select_Featured = $connection->prepare(
        "SELECT id, title, price FROM vehicles WHERE is_featured = ?  AND status = 'ACTIVE' LIMIT 3"
    );
    $select_Featured->bind_param("i", $featured);
    $select_Featured->execute();

    // Use get_result() for easier fetching (if available)
    $result = $select_Featured->get_result();
    $featured_vehicles = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $select_Featured->close();
    return $featured_vehicles;
}


function get_vehicle_image($vehicle_id, $connection)
{
    // Fetch vehicle image
    $select_image = $connection->prepare(
        "SELECT image_path FROM vehicle_images WHERE image_vehicle_id = ? LIMIT 1"
    );
    $select_image->bind_param("i", $vehicle_id);
    $select_image->execute();
    $result = $select_image->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        return $row['image_path']; // Return the image path
    }

    return null; // Return null if no image found
}

function get_popular_vehicles($connection, $limit = 3)
{
    // Fetch popular vehicles
    $select_Popular = $connection->prepare(
        "SELECT id, title, price FROM vehicles WHERE is_popular = ? AND status = 'ACTIVE' LIMIT ?"
    );
    $popular = 1;
    $select_Popular->bind_param("ii", $popular, $limit);
    $select_Popular->execute();

    // Use get_result() for easier fetching (if available)
    $result = $select_Popular->get_result();
    $popular_vehicles = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $select_Popular->close();
    return $popular_vehicles;
}

// Function to fetch all makes and their listing counts
function getAllMakes(mysqli $connection): array
{
    $sql = "SELECT m.make_id, m.make_name, m.make_image, COUNT(v.id) AS listings_count
            FROM makes m
            LEFT JOIN vehicles v ON m.make_id = v.make_id
            GROUP BY m.make_id, m.make_name, m.make_image";
    $stmt = $connection->prepare($sql);
    $makes = [];
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $makes[] = $row;
        }
        $stmt->close();
    } else {
        error_log("MySQL Error in getAllMakes: " . $connection->error);
    }
    return $makes;
}

function get_all_vehicles($connection)
{
    $select_All_listings = $connection->prepare(
        "SELECT id, title, price, description, stock FROM vehicles WHERE status = 'ACTIVE' ORDER BY created_at DESC"
    );
    $select_All_listings->execute();
    $result = $select_All_listings->get_result();
    $all_vehicles = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $select_All_listings->close();
    return $all_vehicles;
}

function get_all_recent_vehicles($connection)
{
    $select_All_listings = $connection->prepare(
        "SELECT id, title, price, description, stock FROM vehicles WHERE status = 'ACTIVE' ORDER BY created_at DESC LIMIT 3"
    );
    $select_All_listings->execute();
    $result = $select_All_listings->get_result();
    $all_vehicles = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $select_All_listings->close();
    return $all_vehicles;
}

function get_vehicle($vehicle_id, $connection)
{
    $select_vehicle = $connection->prepare(
        "SELECT id, title, price, description, stock FROM vehicles WHERE id = ? AND status = 'ACTIVE'"
    );
    $select_vehicle->bind_param("i", $vehicle_id);
    $select_vehicle->execute();
    $result = $select_vehicle->get_result();
    $vehicle = $result ? $result->fetch_assoc() : [];
    $select_vehicle->close();
    return $vehicle;
}

// Make Functions //
function getMakeById(mysqli $connection, int $make_id): ?array
{
    $sql = "SELECT make_id, make_name, make_image 
            FROM makes 
            WHERE make_id = ?";

    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $make_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $make = $result->fetch_assoc();
        $stmt->close();
        return $make;
    }
    return null;
}

function getListingsByMake(mysqli $connection, int $make_id): array
{
    $sql = "SELECT v.id as listing_id, 
                   v.title, 
                   v.price,
                   MIN(COALESCE(vi.image_path, '/Projects/AuraEdition/assets/images/default-car.jpg')) as image_url
            FROM vehicles v
            LEFT JOIN vehicle_images vi ON v.id = vi.image_vehicle_id
            WHERE v.make_id = ? AND v.status = 'ACTIVE'
            GROUP BY v.id, v.title, v.price
            ORDER BY v.created_at DESC;";

    $stmt = $connection->prepare($sql);
    $listings = [];

    if ($stmt) {
        $stmt->bind_param("i", $make_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $listings[] = $row;
        }
        $stmt->close();
    }

    return $listings;
}
// Make Functions //


// Order Functions //

function fetchOrdersByUserId($connection, $user_id)
{
    if (!isset($user_id)) {
        header("Location: /Projects/AuraEdition/auth/login.php");
        exit;
    }

    // Fetch the latest order for the user
    $stmt = $connection->prepare("SELECT order_id, total_price, orderd_at FROM orders WHERE user_id = ? ORDER BY orderd_at DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $order_result = $stmt->get_result();
    $order = $order_result->fetch_assoc();
    $stmt->close();

    if (!$order) {
        return null;
    }

    // Fetch order items
    $stmt_items = $connection->prepare("SELECT vehicle_id, price FROM order_items WHERE order_id = ?");
    $stmt_items->bind_param("i", $order['id']);
    $stmt_items->execute();
    $items_result = $stmt_items->get_result();
    $order_items = [];
    while ($row = $items_result->fetch_assoc()) {
        $order_items[] = $row;
    }
    $stmt_items->close();

    return ['order' => $order, 'order_items' => $order_items];
}

function fetchUserById($connection, $user_id)
{
    $stmt = $connection->prepare("SELECT id, fname, email, address, city, state, zip, phone FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user;
}


function getOrderItemsByOrderId($connection, $order_id)
{
    $stmt = $connection->prepare("SELECT id, vehicle_id, price FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order_items = [];

    while ($row = $result->fetch_assoc()) {
        $order_items[] = $row;
    }
    $stmt->close();
    return $order_items;
}

// Order Functions //


// Cart Functions //

function addToCart($connection, $user_id, $vehicle_id, $quantity = 1)
{
    if (!isset($user_id) || !isset($vehicle_id)) {
        return false;
    }

    $stmt = $connection->prepare("INSERT INTO cart_items (cart_id, vehicle_id, quantity) VALUES ((SELECT cart_id FROM carts WHERE user_id = ?), ?, ?)");
    $stmt->bind_param("iii", $user_id, $vehicle_id, $quantity);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}


function getCartItemsByUserId(mysqli $connection, ?int $user_id): array
{
    if (!isset($user_id)) {
        return []; // Return an empty array if user is not logged in.
    }

    // Select cart_item_id for precise removal
    $sql = "SELECT 
                ci.cart_item_id,
                ci.vehicle_id, 
                ci.quantity,
                v.title,
                v.price,
                COALESCE((SELECT vi.image_path FROM vehicle_images vi WHERE vi.image_vehicle_id = v.id LIMIT 1), '/Projects/AuraEdition/assets/images/default-car.jpg') as image_path
            FROM cart_items ci
            JOIN carts c ON ci.cart_id = c.cart_id
            JOIN vehicles v ON ci.vehicle_id = v.id
            WHERE c.user_id = ?";

    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed for getCartItemsByUserId: " . $connection->error);
        return [];
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart_items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $cart_items;
}

function removeFromCart($connection, $cart_item_id)
{
    if (!isset($cart_item_id)) {
        return false;
    }
    $stmt = $connection->prepare("DELETE FROM cart_items WHERE cart_item_id = ?");
    if (!$stmt) return false;
    $stmt->bind_param("i", $cart_item_id);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

function cartExists($connection, $user_id)
{
    if (!isset($user_id)) {
        return false;
    }
    $stmt = $connection->prepare("SELECT cart_id FROM carts WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows > 0;
}

function createCart($connection, $user_id)
{
    if (!isset($user_id)) {
        return false;
    }
    $stmt = $connection->prepare("INSERT INTO carts (user_id) VALUES (?)");
    $stmt->bind_param("i", $user_id);
    $success = $stmt->execute();
    $stmt->close();
    return true;
}


function clearCart($connection, $user_id)
{
    if (!isset($user_id)) {
        return false;
    }

    $stmt = $connection->prepare("DELETE FROM cart_items WHERE cart_id IN (SELECT cart_id FROM carts WHERE user_id = ?)");
    $stmt->bind_param("i", $user_id);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

// Cart Functions //


function getPurchasedItemsByUserId($connection, $user_id)
{
    if (!isset($user_id)) {
        return [];
    }
    $stmt = $connection->prepare("SELECT id, vehicle_id, quantity, price FROM order_items 
    WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = ?)");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $purchased_items = [];
    while ($row = $result->fetch_assoc()) {
        $purchased_items[] = $row;
    }
    $stmt->close();
    return $purchased_items;
}

// User Functions //

/**
 * Get user data with address information
 * @param mysqli $connection Database connection
 * @param int $user_id User ID
 * @return array|null User data or null if not found
 */
function getUserWithAddress($connection, $user_id)
{
    $stmt = $connection->prepare(
        "SELECT u.*, ua.address, ua.city, ua.state, ua.country
        FROM users u 
        LEFT JOIN user_addresses ua ON u.id = ua.address_user_id 
        WHERE u.id = ?"
    );
    if (!$stmt) return null;

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Wishlist Functions //
function addToWishlist($connection, $user_id, $vehicle_id)
{
    if (!isset($user_id) || !isset($vehicle_id)) {
        return false;
    }
    $stmt = $connection->prepare("INSERT INTO wishlist_items (user_id, vehicle_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $vehicle_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}


function getWishlistItemsByUserId($connection, $user_id)
{
    if (!isset($user_id)) {
        return [];
    }
    $stmt = $connection->prepare("SELECT id, vehicle_id FROM wishlist_items WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $wishlist_items = [];
    while ($row = $result->fetch_assoc()) {
        $wishlist_items[] = $row;
    }
    $stmt->close();
    return $wishlist_items;
}

function removeFromWishlist($connection, $wishlist_item_id)
{
    if (!isset($wishlist_item_id)) {
        return false;
    }
    $stmt = $connection->prepare("DELETE FROM wishlist_items WHERE id = ?");
    if (!$stmt) return false;
    $stmt->bind_param("i", $wishlist_item_id);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}


// Wishlist Functions //


// Pagination Functions //
function get_vehicles_paginated($connection, $limit, $offset)
{
    $stmt = $connection->prepare("SELECT * FROM vehicles ORDER BY id DESC LIMIT ? OFFSET ? ");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicles = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $vehicles;
}

function get_total_vehicles($connection)
{
    $result = $connection->query("SELECT COUNT(*) as count FROM vehicles");
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Pagination Functions //

function getModels($connection, $make_name = null)
{
    $models = [];
    if ($make_name) {
        // Use the correct foreign key column name for make in your model table
        $stmt = $connection->prepare("SELECT model_id, model_name FROM model WHERE model_make_id = (SELECT make_id FROM makes WHERE make_name = ? LIMIT 1)");
        $stmt->bind_param("s", $make_name);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $models[] = $row;
        }
        $stmt->close();
    } else {
        $result = $connection->query("SELECT model_id, model_name FROM model");
        while ($row = $result->fetch_assoc()) {
            $models[] = $row;
        }
    }
    return $models;
}

// Get filter/search values

function get_filter_values($connection, $items_per_page, $offset)
{
    $make = $_GET['make'] ?? '';
    $model = $_GET['model'] ?? '';
    $price = $_GET['price'] ?? '';
    $q = $_GET['q'] ?? '';

    $where = ["status = 'ACTIVE'"];
    $params = [];
    $types = '';

    if ($make) {
        $where[] = "make_id = (SELECT make_id FROM makes WHERE make_name = ? LIMIT 1)";
        $params[] = $make;
        $types .= 's';
    }
    if ($model) {
        // Use the correct foreign key column name for make in your model table
        $where[] = "model_id = (SELECT model_id FROM model WHERE model_name = ? LIMIT 1)";
        $params[] = $model;
        $types .= 's';
    }
    if ($price) {
        if ($price == 'under100') {
            $where[] = "price < 100000";
        } elseif ($price == '100to250') {
            $where[] = "price >= 100000 AND price <= 250000";
        } elseif ($price == 'over250') {
            $where[] = "price > 250000";
        }
    }
    if ($q) {
        $where[] = "(title LIKE ? OR description LIKE ?)";
        $params[] = "%$q%";
        $params[] = "%$q%";
        $types .= 'ss';
    }

    $sql = "SELECT * FROM vehicles";
    if ($where) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }
    $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $params[] = $items_per_page;
    $params[] = $offset;
    $types .= 'ii';

    $stmt = $connection->prepare($sql);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $All_vehicles = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Get total count for pagination (without LIMIT)
    $sql_count = "SELECT COUNT(*) as count FROM vehicles";
    if ($where) {
        $sql_count .= " WHERE " . implode(' AND ', $where);
    }
    $stmt_count = $connection->prepare($sql_count);
    if ($params && strlen($types) > 2) { // Exclude LIMIT/OFFSET
        $count_types = substr($types, 0, -2);
        $count_params = array_slice($params, 0, -2);
        $stmt_count->bind_param($count_types, ...$count_params);
    }
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $total_vehicles = $result_count->fetch_assoc()['count'] ?? 0;
    $stmt_count->close();
    $total_pages = ceil($total_vehicles / $items_per_page);

    $vehicle_images = [];
    foreach ($All_vehicles as $vehicle) {
        $image = get_vehicle_image($vehicle['id'], $connection);
        $vehicle_images[$vehicle['id']] = $image ? $image : '/Projects/AuraEdition/products/img/default.jpg';
    }

    return [
        'All_vehicles' => $All_vehicles,
        'vehicle_images' => $vehicle_images,
        'total_vehicles' => $total_vehicles,
        'total_pages' => $total_pages
    ];
}
