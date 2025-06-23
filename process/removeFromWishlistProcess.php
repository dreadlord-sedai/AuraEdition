<?php

if (isset($_POST['vehicle_id'])) {
    $vehicle_id = $_POST['vehicle_id'];
    removeFromWishlist($connection, $vehicle_id);
    echo "success";
} else {
    echo "error";
}
