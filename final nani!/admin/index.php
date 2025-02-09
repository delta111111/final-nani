<?php
session_start();
if(!isset($_SESSION['user_id'])){

    header('location: ../select user/index.html');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User Overview</title>
       <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <style>

               .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #2c3e50;
            padding-top: 56px;
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar-collapsed {
            width: 70px;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #34495e;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .sidebar-collapsed .nav-link span {
            display: none;
        }
        .sidebar-collapsed .nav-link i {
            margin-right: 0;
        }
        .content {
            margin-left: 250px;
            padding-top: 56px;
            transition: all 0.3s;
        }
        .content-expanded {
            margin-left: 70px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            .sidebar .nav-link span {
                display: none;
            }
            .sidebar .nav-link i {
                margin-right: 0;
            }
            .content {
                margin-left: 70px;
            }
        }
     
        .table-responsive {
            overflow-x: auto;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
        .status-active {
            color: #198754;
        }
        .status-inactive {
            color: #dc3545;
        }
    </style>
</head>
<body class="bg-light">
   
    <?php 
    include 'includes/sidebar.php';
    include 'includes/total.php'; 
    ?>

    <div class="content" id="content">
        <div class="container-fluid py-4">
            <h1 class="h3 mb-4">User Overview</h1>
            
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Active Users</h5>
                            <p class="card-text"><?php echo number_format($user_counts['active']); ?></p>
                            <p class="card-subtitle">Currently active</p>
                        </div>
                    </div>
                </div>
 
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">Inactive Users</h5>
                            <p class="card-text"><?php echo number_format($user_counts['deactivate']); ?></p>
                            <p class="card-subtitle">Inactive accounts</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text"><?php echo number_format($user_counts['total']); ?></p>
                            <p class="card-subtitle">All registered users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('sidebar-collapsed');
            document.getElementById('content').classList.toggle('content-expanded');
        });
    </script>
</body>
</html>

