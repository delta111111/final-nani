
<?php

session_start();

if(!isset($_SESSION['email'])){

    header('location: admin_verify_email.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <title>Login</title>
 <style>

    :root {
    --primary-color: #4a90e2;
    --secondary-color: #50c878;
    --text-color: #333;
    --background-color: #f8f9fa;
    --card-background: #ffffff;
    --shadow-color: rgba(0, 0, 0, 0.1);
}
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        div {
            position: relative;
            width: 90%; 
        }
        div input {
            width: 92%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        div i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }
        button {
            background-color:var(--primary-color);
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            width: 90%; 
        }
        button:hover {
            background-color: var(--primary-color);
        }
        .toggle-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
        .toggle-btn {
            background-color: #f0f0f0;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .toggle-btn.active {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div>
            
    <?php if (isset($_GET['err'])) { ?>
    <p style="text-align: center; color:red"><?=$_GET['err'];?></p>
      <?php unset($_GET['err']); ?>
      <?php } ?>
        </div>
        <h2 id="loginTitle">Admin</h2>
       <form id="loginForm" method="post" action="forgot_process.php">
            <div>
                <input type="password" id="current-pass" placeholder="Current Password" name="current-pass" required>
            </div>
               <div>
                <input type="password" id="confirm-pass" placeholder="Confirm Password" name="confirm-pass" required>
            </div>
            <div>
            </div>
            <button type="submit" name="admin_reset-pas-btn">Submit</button>
        </form>
    </div>
    
</body>
</html>