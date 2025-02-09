<?php
// Get the current page name (without the .php extension)
$currentPage = basename($_SERVER['PHP_SELF'], ".php");
?>

<nav class="navbar navbar-expand-lg mb-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
            <img src="VHI.png" alt="Logo">
            <span>BNS</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'index') ? 'active' : ''; ?>" href="index.php">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'profile') ? 'active' : ''; ?>" href="profile.php">
                        <i class="fas fa-user me-2"></i>Profile
                    </a>
                </li>
            </ul>
            <div class="navbar-nav">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-profile" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="../image/profile/default.png" alt="User Avatar">
                        <span><?=$_SESSION['fname']?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item logout-btn" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
