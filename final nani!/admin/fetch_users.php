<?php
include 'dbcon.php';

$query = "SELECT * FROM users";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

// Output the users array as a JSON response
echo json_encode($users);
?>
