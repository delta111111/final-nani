<?php
session_start();
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user-btn'])) {
        // User login
        $username = $_POST['username'];
        $password = $_POST['password'];
        $userHomePage = "../users/index.php";
        $userLoginPage = "user.php";
        $tablename = "users";
        VerifyAcc($conn, $tablename, $userLoginPage, $userHomePage, $username, $password, 'user');
    }

    if (isset($_POST['admin-btn'])) {
        // Admin login
        $username = $_POST['username'];
        $password = $_POST['password'];
        $adminHomePage = "../admin/index.php";
        $adminLoginPage = "admin.php";
        $tablename = "admin";
        VerifyAcc($conn, $tablename, $adminLoginPage, $adminHomePage, $username, $password, 'admin');
    }
}

function VerifyAcc($conn, $tablename, $navigateToLogin, $navigateToHome, $email, $password, $userType) {
    // Prepare the query to fetch user details
    $select = $conn->prepare("SELECT * FROM $tablename WHERE email=?");
    $select->bind_param("s", $email);
    $select->execute();
    $res = $select->get_result();

    if ($res->num_rows > 0) {
        // Fetch user data
        $rows = $res->fetch_assoc();

        // If it's a user login, check for activation status
        if ($userType === 'user') {
            if ($rows['active_status'] === 'deactivate') {
                // Account is inactive, redirect to login with error message
                header("location:$navigateToLogin?err=Your account is inactive. Please activate it.");
                exit();
            }
        }

        // Check password validity
        if (password_verify($password, $rows['password'])) {
            // User authenticated successfully, set session variables
            $_SESSION['is_loggedin'] = true;
            $_SESSION['user_id'] = $rows['id'];
            $_SESSION['email'] = $rows['email']; 
            $_SESSION['fname'] = $rows['fname'];
            $_SESSION['lname'] = $rows['lname'];
            $_SESSION['assign_area'] =  $rows['assign_area'];
            header("location:$navigateToHome");
        } else {
            // Incorrect password, redirect to login with error message
            header("location:$navigateToLogin?err=Incorrect password");
        }
    } else {
        // User not found, redirect to login with error message
        header("location:$navigateToLogin?err=Invalid credentials");
    }
}
?>
