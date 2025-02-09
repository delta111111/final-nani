   <div class="sidebar" id="sidebar">
   
                       <!--  <a class="nav-link" href="#" id="sidebarToggle">
                            <i class='bx bx-menu'></i>
                        </a> -->
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i class='bx bxs-smile fs-4 me-2'></i>
            <span class="fs-5">Rural Health</span>
        </a>
        <hr class="text-white">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                    <i class='bx bxs-dashboard'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="user_management.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'user_management.php' ? 'active' : ''; ?>">
                    <i class='bx bx-file-find'></i>
                    <span>User Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="mapping.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'mapping.php' ? 'active' : ''; ?>">
                    <i class='bx bx-location-plus'></i>
                    <span>Mapping</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="health.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'health.php' ? 'active' : ''; ?>">
                    <i class='bx bx-task'></i>
                    <span>Health Records</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="monthly_report.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'monthly_report.php' ? 'active' : ''; ?>">
                    <i class='bx bx-task'></i>
                    <span>Monthly_Report</span>
                </a>
            </li>s
        </ul>
        <hr class="text-white">
         <li class="nav-item">
                <a href="logout.php" class="nav-link">
                   <i class="bx bx-log-out"></i>
                    <span>Logout</span>
                </a>
            </li>
    </div>