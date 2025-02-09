<?php
include 'dbcon.php';

// Fetch patient details
if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];
    $query = "SELECT * FROM table_form WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    echo json_encode($patient);
    exit;
}

// Update patient details
if (isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $health_status = $_POST['health_status'];
    
    $query = "UPDATE table_form SET Fname = ?, Lname = ?, Gender = ?, Age = ?, Purok = ?, Weight = ?, Height = ?, Health_Status = ? WHERE id = ?";
    
    $stmt = $connection->prepare($query);
    $stmt->bind_param("sssssiisi", $fname, $lname, $gender, $age, $address, $weight, $height, $health_status, $update_id);
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
    exit;
}



