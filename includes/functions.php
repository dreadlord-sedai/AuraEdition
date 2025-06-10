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
        "SELECT image FROM vehicle_images WHERE vehicle_id = ? LIMIT 1"
    );
    $select_image->bind_param("i", $vehicle_id);
    $select_image->execute();
    $result = $select_image->get_result();
    
    if ($result && $row = $result->fetch_assoc()) {
        return $row['image'];
    }
    
    return null; // Return null if no image found
}