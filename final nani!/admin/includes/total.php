<?php
include 'dbcon.php';



$total_users_query = "SELECT COUNT(*) as total FROM users";
$total_result = $connection->query($total_users_query);
$total_users = $total_result->fetch_assoc()['total'];

// Query to get active users
$active_users_query = "SELECT COUNT(*) as active FROM users WHERE active_status = 'active'";
$active_result = $connection->query($active_users_query);
$active_users = $active_result->fetch_assoc()['active'];

// Calculate inactive users
$inactive_users = $total_users - $active_users;

// Close the connection
$connection->close();

// Create an array with the results
$user_counts = [
    'total' => $total_users,
    'active' => $active_users,
    'deactivate' => $inactive_users
];

// You can return this as JSON if you're using AJAX
// echo json_encode($user_counts);

// Or you can use these variables directly in your HTML
?>