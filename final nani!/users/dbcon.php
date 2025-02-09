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


// $connection = new mysqli('localhost', 'username', 'password', 'table_form');
// if ($connection->connect_error) {
//     die("Connection failed: " . $connection->connect_error);
// }




?>



