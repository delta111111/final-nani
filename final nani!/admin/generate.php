<?php
session_start();
require_once 'dbcon.php';
require '../PHP mailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
	$email = $_POST['email'];

	$password = generatePassword(12);

// Hash the password for secure storage
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	$mail = new PHPMailer(true);

    $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;

            //Send using SMTP
    $mail->isSMTP();

            //Set the SMTP server to send through
    $mail->Host = 'smtp.gmail.com';


     //Enable SMTP authentication
    $mail->SMTPAuth = true;

    //SMTP username
    $mail->Username = 'qgis.healthinfo@gmail.com';

     //SMTP password
    $mail->Password = 'qbqhdhcpfhodgeqz';

     //Enable TLS encryption;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->Port = 465;

    //Recipients

    $mail->setFrom('qgis.healthinfo@gmail.com', 'Visualization of Health Information');

    //Add a recipient
    $mail->addAddress($email);

     //Set email format to HTML
    $mail->isHTML(true);

    $mail->Subject = 'User password';
    $mail->Body    = '<p>Your password is: ' . $password . '</p>';
    $mail->send();



$email_check_sql = "SELECT * FROM users WHERE email = '$email'";
$result = $connection->query($email_check_sql);

if ($result->num_rows > 0) {
    // Email already exists
    echo json_encode(['success' => false, 'message' => 'Email already exists. Please use a different email.']);
} else {
    // Email does not exist, proceed with the insert
    $sql = "INSERT INTO users (lname, fname, email, password) VALUES ('$lname', '$fname', '$email', '$hashed_password')";
    if ($connection->query($sql) === TRUE) {
        $last_id = $connection->insert_id;

        // Now you can update the purok_area table
        $update_sql = "UPDATE purok_area SET user_id = ? WHERE assign_area = ?";
        $update_stmt = $connection->prepare($update_sql);
        $assign_area = $_POST['assign_area'];  // Ensure assign_area is properly set from POST data

        // Bind parameters and execute update
        $update_stmt->bind_param("is", $last_id, $assign_area);
        if ($update_stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Password generated and stored successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating purok_area: ' . $update_stmt->error]);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Error inserting user: ' . $connection->error]);
    }
}

$connection->close();



}


function generatePassword($length = 8) {

	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%&*?';
	$password = substr(str_shuffle($characters), 0, $length);
	return $password;
}



?>