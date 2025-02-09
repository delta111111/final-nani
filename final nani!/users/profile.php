<?php

session_start();

if(!isset( $_SESSION['user_id'])){

    header('location: ../select user/index.html');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VHI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .navbar-brand img {
            max-height: 50px;
            border-radius: 50%;
        }

        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --light-background: #f4f6f9;
        }

        body {
            background-color: var(--light-background);
        }

        .navbar-nav .nav-link {
            color: var(--primary-color);
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
            margin: 0 10px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--accent-color);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background-color: var(--accent-color);
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
            left: 0;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .dropdown-menu {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .logout-btn {
            color: #dc3545;
        }

        .logout-btn:hover {
            background-color: #f8d7da;
        }

        .container-profile {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header h3 {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .profile-header p {
            color: var(--secondary-color);
            font-size: 1rem;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info .form-control {
            background-color: #f4f6f9;
        }

        /* Image Upload */
        .profile-img-container {
            text-align: center;
        }

        .profile-img-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .custom-file-input {
            border: none;
            border-radius: 5px;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
        }

        .custom-file-input:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
   <?php include 'navbar.php'; ?>

    <!-- Profile Page -->
    <div class="container container-profile">
        <div class="profile-header">
            <h3>My Profile</h3>
            <p>View and update your personal information below.</p>
        </div>

        <form id="profileForm" enctype="multipart/form-data">
            <!-- Profile Image Upload -->
            <div class="profile-img-container">
                <img src="user-avatar.jpg" id="profileImage" alt="Profile Image">
                <input type="file" class="custom-file-input" name="profile_image" id="profile_image" accept="image/*">
            </div>

            <!-- Patient Information -->
                 <div class="profile-info">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?=$_SESSION['lname']?>" required>
            </div>
            <div class="profile-info">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?=$_SESSION['fname']?>" required>
            </div>

            <div class="profile-info">
                <label for="email" class="mb-2">Email Address</label>
                  <div class="mb-3 input-group">
                  <input type="email" name="email" class="form-control form-control-md" value="<?=$_SESSION['email']?>" id="email" required readonly>
            </div>

            <!-- <div class="profile-info">
                <label for="position" class="form-label">Position</label>
                <select class="form-select" id="position" name="position" required>
                    <option value="BHW1" selected>BHW1</option>
                    <option value="BHW2">BHW2</option>
                    <option value="BHW3" >BHW3</option>
                    <option value="BHW4">BHW4</option>
                    <option value="BHW5" >BHW5</option>
                    <option value="BHW6">BHW6</option>
                    <option value="BHW7" >BHW7</option>
                    <option value="BHW8">BHW8</option>
                    <option value="BHW9">BHW9</option>
                </select>
            </div> -->

        

            <div class="profile-info">
                <label for="designated area" class="form-label">Designated area</label>
                <input type="number" class="form-control" id="designated area" name="designated area" value="<?=$_SESSION['assign_area']?>" required readonly>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle profile image preview on file selection
        $('#profile_image').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profileImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        // Handle form submission for profile update (including image upload)
        $('#profileForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: 'update_profile.php', // PHP file to handle profile update
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response === 'success') {
                        alert('Profile updated successfully!');
                    } else {
                        alert('Error updating profile!');
                    }
                }
            });
        });
    </script>

</body>

</html>
