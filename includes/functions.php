<?php
function get_featured_vehicles($connection, $limit = 3)
{
    // Fetch featured vehicles
    $featured = 1;
    $select_Featured = $connection->prepare(
        "SELECT id, title, price FROM vehicles WHERE is_featured = ? LIMIT 3"
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
        "SELECT id, title, price FROM vehicles WHERE is_popular = ? LIMIT ?"
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
function getAllMakes(mysqli $connection): array {
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

function getAllVehicles($connection) {
    $select_All_listings = $connection->prepare(
        "SELECT id, title, price, description, stock FROM vehicles"
    );
    $select_All_listings->execute();
    $result = $select_All_listings->get_result();
    $all_vehicles = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $select_All_listings->close();
    return $all_vehicles;
}