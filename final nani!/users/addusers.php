<?php

session_start();

if(!isset($_SESSION['user_loggedin?'])){

header('location: ../index.html');
exit;
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    
   <?php include 'includes/style.php';?>

    <title>add_users</title>
</head>

<body>
 <?php include 'includes/sidebar.php'; ?>


 


<?php include 'includes/script.php';?>
</body>
</html>