<?php
include 'dbcon.php'; 

if (isset($_GET['id'])) {
    $userId = $_GET['id'];  

    // Query to fetch the specific user by ID
    $query = "SELECT * FROM users WHERE id = '$userId'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    $user = mysqli_fetch_assoc($result); 

    if ($user) {
        echo json_encode($user);  
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User ID is required']);
}
?>
