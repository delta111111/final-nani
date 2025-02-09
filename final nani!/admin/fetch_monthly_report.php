<?php
include 'dbcon.php';


$month = isset($_GET['month']) ? $_GET['month'] : 1;  

// Get the selected health status from the request (optional)
$health_status = isset($_GET['health_status']) ? $_GET['health_status'] : '';  

// Base query to fetch data filtered by the selected month
$query = "SELECT * FROM table_form WHERE MONTH(Created_at) = ?";

// Add health status filter if provided
if ($health_status) {
    $query .= " AND Health_Status = ?";
}

// Prepare the query
$stmt = mysqli_prepare($connection, $query);

// Bind the month parameter and optionally the health status parameter
if ($health_status) {
    mysqli_stmt_bind_param($stmt, "is", $month, $health_status);
} else {
    mysqli_stmt_bind_param($stmt, "i", $month);
}

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Initialize an array to store the users
$users = [];

// Fetch the results into the users array
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

// Output the users array as a JSON response
echo json_encode($users);

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($connection);
?>
