<?php
include 'dbcon.php';


if(isset($_GET['decline'])){
    $id = $_GET['decline'];
    $query = "UPDATE users SET active_status='deactivate' WHERE id=$id";
    $result = mysqli_query($connection, $query);

    if($result){
        // If the operation is successful, redirect.
        header('location: user_management.php');
        exit; // Ensure no further processing happens after the redirect
    }
}

if(isset($_GET['activate'])){
    $id = $_GET['activate'];
    $query = "UPDATE users SET active_status='active' WHERE id=$id";
    $result = mysqli_query($connection, $query);

    if($result){
        // If the operation is successful, redirect.
        header('location: user_management.php');
        exit; // Ensure no further processing happens after the redirect
    }
}


//Admin Approval 


  if(isset($_GET['approve'])){


    $id =  $_GET['approve'];
    $approved = "Approved";



    $stmt = $connection->prepare("UPDATE `table_form` SET Action_status=? WHERE id = ?");

    // Bind parameters
    $stmt->bind_param("si", $approved, $id);

    // Execute the statement
    if ($stmt->execute()) {
  

        header('location:health.php?update_msg=Approved Successfully');
        exit(); // Always exit after a redirect
    }
    }



  if(isset($_GET['health_decline'])){
   
      $id =  $_GET['health_decline'];
    $approved = "Declined";



    $stmt = $connection->prepare("UPDATE `table_form` SET Action_status=? WHERE id = ?");

    // Bind parameters
    $stmt->bind_param("si", $approved, $id);

    // Execute the statement
    if ($stmt->execute()) {
  

        header('location:health.php?update_msg=Declined Successfully');
        exit(); // Always exit after a redirect
    }


  }




// Ensure the necessary data is provided
if (!isset($_POST['fullname']) || !isset($_POST['email']) || !isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;  // Make sure no further code runs after this response
}

$userId = $_POST['id'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];

// Update the user data
$sql = "UPDATE users SET fullname = ?, email = ? WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param('ssi', $fullname, $email, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
}

$connection->close();
?>
