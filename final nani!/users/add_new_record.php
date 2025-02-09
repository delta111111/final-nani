<?php
include 'dbcon.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $barangay = $_POST['barangay'];
    $purok = $_POST['addpurok'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $health_status = $_POST['addhealth_status'];

    // Insert the data into the database
    $sql = "INSERT INTO table_form (Fname, Lname, Gender, Age, Barangay, Purok, Weight, Height, Health_Status) 
            VALUES ('$fname', '$lname', '$gender', '$age', '$barangay', '$purok', '$weight', '$height', '$health_status')";

    if ($connection->query($sql) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }







}
