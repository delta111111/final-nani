<?php
// dbcon.php
$servername = "localhost"; // or your server name
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "user_account"; // your database name

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

?>



