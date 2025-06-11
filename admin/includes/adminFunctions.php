<?php
function getUser($connection, $user_id) {
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = $connection->query($query);
    return $result->fetch_assoc();
}