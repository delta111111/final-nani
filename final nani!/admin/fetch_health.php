<?php
include 'dbcon.php';
$query = "
    SELECT * 
    FROM table_form 
    WHERE Action_Status NOT IN ('Approved')
    ORDER BY Health_Status ASC, Fname ASC, Lname ASC, Created_at ASC  
";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}


echo json_encode($users);$query = "
    SELECT * 
    FROM table_form 
    WHERE some_column = ?  -- Replace 'some_column' with your actual column name
    ORDER BY another_column ASC  -- Replace 'another_column' with the column you want to sort by
";
?>
