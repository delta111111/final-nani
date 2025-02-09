<?php

include 'dbcon.php';


if(isset($_POST['search'])){

$search = $_POST['search'];



$query = "SELECT * FROM table_form WHERE Fname LIKE '%{$search}%' OR Lname LIKE '%{$search}%' OR Gender LIKE '%{$search}%' OR  Age LIKE '%{$search}%' OR  Address LIKE '%{$search}%' OR  Weight LIKE '%{$search}%' OR  Height LIKE '%{$search}%' OR  Health_Status LIKE '%{$search}%'";

$result = $connection->query($query);

if($result->num_rows > 0){


	while($row = $result->fetch_assoc()){
	?>

        <tr>
            <td><?php echo $row['id'];?></td>
            <td><?php echo $row['Fname'];?></td>
            <td><?php echo $row['Lname'];?></td>
            <td><?php echo $row['Gender'];?></td>
            <td><?php echo $row['Age'];?></td>
            <td><?php echo $row['Address'];?></td>
            <td><?php echo $row['Weight'];?></td>
            <td><?php echo $row['Height'];?></td>
            <td><?php echo $row['Health_Status'];?></td>
                       <td><?php echo $row['Created_at'];?></td>
            <td>
                <a href="update-page.php?id=<?php echo $row['id'];?>" class="btn btn-success">Update 

                <a href="delete-page.php?id=<?php echo $row['id'];?>" class="btn btn-danger">Delete
            </td>
        </tr>

	<?php	


	}
}


}else{


  $query = "SELECT * FROM table_form";
  $result = $connection->query($query);


  if($result->num_rows > 0){

  	while ($row = $result->fetch_assoc()) {
  	?>
  	
      <tr>
            <td><?php echo $row['id'];?></td>
            <td><?php echo $row['Fname'];?></td>
            <td><?php echo $row['Lname'];?></td>
            <td><?php echo $row['Gender'];?></td>
            <td><?php echo $row['Age'];?></td>
            <td><?php echo $row['Address'];?></td>
            <td><?php echo $row['Weight'];?></td>
            <td><?php echo $row['Height'];?></td>
            <td><?php echo $row['Health_Status'];?></td>
             <td><?php echo $row['Created_at'];?></td>
            <td>
                <a href="update-page.php?id=<?php echo $row['id'];?>" class="btn btn-success">Update 

                <a href="delete-page.php?id=<?php echo $row['id'];?>" class="btn btn-danger">Delete
            </td>
        </tr>

  	<?php	
  		
  	}
  }

}


?>