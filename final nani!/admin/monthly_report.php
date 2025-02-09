<?php

session_start();

if(!isset($_SESSION['is_loggedin'])){

header('location: ../select user/index.html');
exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Health Records</title>
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
    <?php include 'includes/sidebar.php'; ?>

      <div class="content" id="content">

        <button class="btn btn-success position-absolute top-8 end-0 m-3 mb-3" id="downloadBtn">
        <i class="fas fa-download me-2"></i>Download CSV
</button>
       
            <div class="container-fluid py-4">
    
        <div class="row">
                <div class="mb-3 col-md-3">

            <select class="form-select w-50" id="month" name="month">
                <option value="1" selected>All Months</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        </div>

            <div class="mb-3 col-md-3">
    <select name="addhealth_status" id="health" class="form-control" required>
        <option value="" selected>Select Health Status</option>
        <?php 
        include 'dbcon.php';
        $sql = "SELECT * FROM health_conditions";

        $result = mysqli_query($connection,$sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($connection));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $health_conditions = $row['ConditionName'];
                echo "<option value='$health_conditions'>$health_conditions</option>";
            }
        }
        ?>
    </select>
</div>


            
        </select>
        </div>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Monthly Report</h5>
            
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fullname</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Purok</th>
                                        <th>Weight</th>
                                        <th>Height</th>
                                        <th>Health_Status</th>      
                                         <th>Date</th>                                 
                                    </tr>
                                </thead>
                                <tbody id="display">
                               </tbody>
                             
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
    </div>


       <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
    
    <script>
        
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch and populate health status dropdown when the page loads
        fetchHealthConditions();

        // Initially fetch and display users when the page loads
        Table();

        // Add event listener to the month dropdown to fetch data when the month is changed
        const monthDropdown = document.getElementById('month');
        const healthDropdown = document.getElementById('health');
        
        monthDropdown.addEventListener('change', function() {
            Table(monthDropdown.value, healthDropdown.value);  // Pass selected month and health status
        });

        // Add event listener to the health dropdown to fetch data when health status is changed
        healthDropdown.addEventListener('change', function() {
            Table(monthDropdown.value, healthDropdown.value);  // Pass selected month and health status
        });

        // Attach the downloadCSV function to the button click event
        document.getElementById('downloadBtn').addEventListener('click', downloadCSV);
    });

    // Fetch health conditions and populate the health dropdown
  function fetchHealthConditions() {
    fetch('select_health_status.php')
        .then(response => response.json())
        .then(data => {
            const healthDropdown = document.getElementById('health');

            if (data.length === 0) {
                // If no data returned, show a default option
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "No health conditions available";
                healthDropdown.appendChild(option);
                healthDropdown.disabled = true;  // Optionally disable the dropdown if no data
            } else {
                // Populate the dropdown with the health conditions
                data.forEach(condition => {
                    const option = document.createElement('option');
                    option.value = condition;
                    option.textContent = condition;
                    healthDropdown.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error fetching health conditions:', error));
}

    function Table(month = 1, health_status = '') {
        // Send the selected month and health status in the fetch request
        let url = `fetch_monthly_report.php?month=${month}`;
        if (health_status) {
            url += `&health_status=${health_status}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(users => {
                console.log(users); // Check the data fetched from the server

                const display = document.getElementById('display');
                display.innerHTML = ''; // Clear the current table body

                users.forEach((user, index) => {
                    const fullname = user.Fname + " " + user.Lname;
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${fullname}</td>
                            <td>${user.Gender}</td>
                            <td>${user.Age}</td>
                            <td>${user.Purok}</td>
                            <td>${user.Weight}</td>
                            <td>${user.Height}</td>
                            <td>${user.Health_Status}</td>
                            <td>${new Date(user.Created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</td>
                        </tr>
                    `;
                    display.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(error => console.error('Error fetching users:', error));
    }

    // Function to download the displayed data as CSV
    function downloadCSV() {
        const rows = document.querySelectorAll("#display tr");
        const csvRows = [];

        // Loop through each row in the table body
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const csvRow = [];
            cells.forEach(cell => {
                // Add double quotes around the text to handle commas or quotes inside
                csvRow.push(`"${cell.textContent.replace(/"/g, '""')}"`);
            });
            csvRows.push(csvRow.join(','));
        });

        // Add headers to the CSV (for the table columns)
        const headers = ['ID', 'Fullname', 'Gender', 'Age', 'Purok', 'Weight', 'Height', 'Health Status', 'Date'];
        csvRows.unshift(headers.join(','));

        // Combine all rows into a single CSV string
        const csvString = csvRows.join('\n');

        // Create a Blob from the CSV string
        const blob = new Blob([csvString], { type: 'text/csv' });

        // Create a link to trigger the download
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'monthly_report.csv'; // Set default file name

        // Trigger the download
        link.click();
    }


</script>

    </script>
    <script>