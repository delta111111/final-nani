<?php
session_start();
require_once '../connection.php';
include 'email_send_otp.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    //Users Forgot password

    if(isset($_POST['user-verify_email-btn'])){

        $email = $_POST['user_verify_email'];
        $userOtpPage = "user_otp-page.php";
        $userCurrentPage = "user_verify_email.php";
        $tablename = "users";
        VerifyEmail($conn, $tablename, $userCurrentPage, $userOtpPage, $email);
        $otp1 = generateOTP(6);
        $_SESSION['otp1'] = $otp1; 
        $otp_expiration1 = date("Y-m-d H:i:s", strtotime("+10 minutes"));  
        insertOTPToDatabase($conn, $email, $otp1, $otp_expiration1);
        sendOTPEmail($email, $otp1);

    }


      if(isset($_POST['user-otp-btn'])){
       $tablename = 'otp_verifications';
        $adminotp = $_POST['userotp'];
        $navigateToPasswordReset = 'user_password-reset.php';
        $currentpage = 'user_otp-page.php';

         VerifyOtp($conn, $tablename, $adminotp, $navigateToPasswordReset, $currentpage);


    }


    if(isset($_POST['user_reset-pas-btn'])){

        $tablename = 'users';
        $back_to_login = 'user.php';
        $currentPage = 'admin_password-reset.php';
        $currentpage = $_POST['user-current-pass'];
        $confirm_pass = $_POST['user-confirm-pass'];
        $email = $_SESSION['email'];        
        ResetPassword($conn, $tablename, $currentpage, $confirm_pass, $email,$currentPage, $back_to_login);
    }



      //Admin Forgot Password
     if (isset($_POST['admin-verify_email-btn'])) {
    
        $email = $_POST['verify_email'];
        $adminOtpPage = "admin_otp-page.php";
        $adminCurrentPage = "admin_verify_email.php";
        $tablename = "admin";
        VerifyEmail($conn, $tablename, $adminCurrentPage, $adminOtpPage, $email);
        $otp1 = generateOTP(6);
        $_SESSION['otp1'] = $otp1; 
        $otp_expiration1 = date("Y-m-d H:i:s", strtotime("+10 minutes"));  
        insertOTPToDatabase($conn, $email, $otp1, $otp_expiration1);
        sendOTPEmail($email, $otp1);
    }




    if(isset($_POST['admin-otp-btn'])){
       $tablename = 'otp_verifications';
        $adminotp = $_POST['adminotp'];
        $navigateToPasswordReset = 'admin_password-reset.php';
        $currentpage = 'admin_otp-page.php';

         VerifyOtp($conn, $tablename, $adminotp, $navigateToPasswordReset, $currentpage);


    }


    if(isset($_POST['admin_reset-pas-btn'])){

        $tablename = 'admin';
        $back_to_login = 'admin.php';
        $currentPage = 'admin_password-reset.php';
        $currentpage = $_POST['current-pass'];
        $confirm_pass = $_POST['confirm-pass'];
        $email = $_SESSION['email'];        
        ResetPassword($conn, $tablename, $currentpage, $confirm_pass, $email,$currentPage, $back_to_login);
    }


}

function VerifyEmail($conn, $tablename, $currentpage, $navigateToOtpPage, $email) {

    // Prepare the query to fetch user details
    $select = $conn->prepare("SELECT * FROM $tablename WHERE email=?");
    $select->bind_param("s", $email);
    $select->execute();
    $res = $select->get_result();

    if ($res->num_rows > 0) {
        $_SESSION['email'] = $email;
       header("location: $navigateToOtpPage");
    } else {
        // User not found, redirect to login with error message
        header("location:$currentpage?err=Invalid email address");
    }
}



function VerifyOtp($conn, $tablename, $otp, $navigateToPasswordReset, $currentpage){

   $select = $conn->prepare("SELECT * FROM $tablename WHERE otp=?");
    $select->bind_param("s", $otp);
    $select->execute();
    $res = $select->get_result();

    if ($res->num_rows > 0) {
       header("location: $navigateToPasswordReset");
    } else {


        header("location:$currentpage?err=Invalid OTP");
    }

}




function ResetPassword($conn, $tablename, $new_pass, $confirm_pass, $email, $navigateToPasswordReset, $login){



    if($new_pass != $confirm_pass){

      header("location:$currentpage?err=Password does not match");
      exit;  
    }

    $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

   $select = $conn->prepare("UPDATE users SET password=? WHERE email=?");
    $select->bind_param("ss", $hashed_password, $email);
    $select->execute();
    if ($select->execute()) {
       header("location: $login");
    } 

}


?>
