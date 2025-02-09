<?php include('headertable.php');?> 
<?php include('dbcon.php');?> <!-- for connection-->


  <?php

  if (isset($_GET['id'])){
  	$id = $_GET['id'];
    
    
    $query = "SELECT * FROM table_form WHERE id = $id"; 

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error());

    } 
    else {
        $row = mysqli_fetch_assoc($result); // Use fetch_assoc to get an associative array
         }    

} 
 
  ?>


<?php
require_once 'dbcon.php'; 

if (isset($_POST['update-patient'])) {

    $idnew = $_GET['id_new']; 

    // Collect the data from the POST request
    $Fname = $_POST['fname'];
    $Lname = $_POST['lname'];
    $Gender = $_POST['gender'];
    $Age = (int)$_POST['age']; 
    $Address = $_POST['address'];
    $Weight = $_POST['weight'];
    $Height = $_POST['height'];
    $Health_Status = $_POST['health'];

    // Prepare the SQL statement
    $stmt = $connection->prepare("UPDATE `table_form` SET Fname = ?, Lname = ?, Gender = ?, Age = ?, Address = ?, Weight = ?, Height = ?, Health_Status = ? WHERE id = ?");

    // Bind parameters
    $stmt->bind_param("sssisissi", $Fname, $Lname, $Gender, $Age, $Address, $Weight, $Height, $Health_Status, $idnew);

    // Execute the statement
    if ($stmt->execute()) {
         $action = "Pending";
         $update = $connection->prepare("UPDATE `table_form` SET Action_status = ? WHERE id = ?");
         $update->bind_param("si", $action, $idnew);
         $update->execute();

        header('location:sidebar.php?update_msg=You have successfully updated');
        exit(); // Always exit after a redirect
    } else {
        die("Query failed: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();
}
?>



    <form action="update-page.php?id_new= <?php echo $id; ?>" method="post">
        <div class="form-group">
                <label for="Fname">First Name</label>
                <input type="text" name="fname" class="form-control"value="<?php echo $row['Fname'] ?>">
            </div>
            <div class="form-group">
                <label for="Lname">Last Name</label>
                <input type="text" name="lname" class="form-control"value="<?php echo $row['Lname'] ?>">
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <input type="text" name="gender" class="form-control"value="<?php echo $row['Gender'] ?>">
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="text" name="age" class="form-control"value="<?php echo $row['Age'] ?>">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control"value="<?php echo $row['Address'] ?>">
            </div>
            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="text" name="weight" class="form-control"value="<?php echo $row['Weight'] ?>">
            </div>
            <div class="form-group">
                <label for="height">Height</label>
                <input type="text" name="height" class="form-control"value="<?php echo $row['Height'] ?>">
            </div>
            <div class="form-group">
                <label for="health">Health_Status</label>
                <input type="text" name="health" class="form-control"value="<?php echo $row['Health_Status'] ?>">
            </div>

            <input type="submit" class="btn btn-success" name="update-patient" value="Update">

    </form>





<?php include('footertable.php');?>