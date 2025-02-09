<?php
require_once 'dbcon.php';

if (isset($_POST['add_patients'])) {
    $Fname = $_POST['fname'];
    $Lname = $_POST['lname'];
    $Gender = $_POST['gender'];
    $Age = (int)$_POST['age']; // Ensure Age is treated as an integer
    $Purok = $_POST['purok'];
    $Weight = $_POST['weight'];
    $Height = $_POST['height'];
    $Health_Status = $_POST['health'];

    // Prepare the SQL statement using prepared statements
    $stmt = $connection->prepare("INSERT INTO `table_form` (Fname, Lname, Gender, Age, Purok, Weight, Height, Health_Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind parameters
    $stmt->bind_param("sssisiss", $Fname, $Lname, $Gender, $Age, $Purok, $Weight, $Height, $Health_Status);

    // Execute the statement
    if ($stmt->execute()) {
        header('location:sidebar.php?insert_msg=Your data has been added successfully');
        exit(); // Always exit after a redirect
    } else {
        die("Query failed: " . $stmt->error);
    }

    $stmt->close();
}
?>