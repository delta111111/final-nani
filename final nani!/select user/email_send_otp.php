<?php


require '../PHP mailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function insertOTPToDatabase($conn, $email, $otp, $otp_expiration) {


    $sql = "INSERT INTO otp_verifications (email, otp, expiration) VALUES ('$email', '$otp', '$otp_expiration')";
    if ($conn->query($sql) !== TRUE) {
        echo json_encode(['success' => false, 'message' => 'Error inserting OTP into database: ' . $connection->error]);
        exit;
    }
}

function sendOTPEmail($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'qgis.healthinfo@gmail.com'; //SMTP username
        $mail->Password = 'qbqhdhcpfhodgeqz'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable TLS encryption;
        $mail->Port = 465; //Set TCP port to connect to

        //Recipients
        $mail->setFrom('qgis.healthinfo@gmail.com', 'Visualization of Health Information');
        $mail->addAddress($email); //Add a recipient

        //Set email format to HTML
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = '<p>Your OTP code is: <strong>' . $otp . '</strong></p>';

        // Send the email
        $mail->send();

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
        exit;
    }
}

// Generate a random OTP (6 digits)
function generateOTP($length = 6) {
    $characters = '0123456789'; // Only digits for OTP
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $otp;
}
?>
