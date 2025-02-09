<?php

session_start();

if(!isset($_SESSION['is_loggedin'])){

header('location: ../select user/index.html');
exit;
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="tables.css">
	    <link rel="stylesheet" href="navs.css">
	<title>	tables</title>
 

</head>
<body>
