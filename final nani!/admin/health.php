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

            <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Health Management</h5>
            
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
                                        <th>Address</th>
                                        <th>Weight</th>
                                        <th>Height</th>
                                        <th>Health_Status</th>
                                       <th>Approval Status</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
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


<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="actions.php" method="post">
                    <input type="hidden" id="editUserId" name="id">
                    <div class="mb-3">
                        <label for="editFullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="editFullName" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>





       <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const sidebar = document.getElementById('sidebar');
        //     const content = document.getElementById('content');
        //     const sidebarToggle = document.getElementById('sidebarToggle');

        //     sidebarToggle.addEventListener('click', function(e) {
        //         e.preventDefault();
        //         sidebar.classList.toggle('sidebar-collapsed');
        //         content.classList.toggle('content-expanded');
        //     });
        // });


document.addEventListener('DOMContentLoaded', function () {
    // Initially fetch and display users when the page loads
    Table();

    // Handle form submission to add a new user
   
    // Handle form submission to update a user
    const editUserForm = document.getElementById('editUserForm');
    if (editUserForm) {
        editUserForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this);
            const alertMessage = document.getElementById('editAlertMessage');
            const loadingSpinner = document.getElementById('editLoadingSpinner'); 
            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));

            // Show the loading spinner
            if (loadingSpinner) {
                loadingSpinner.classList.remove('d-none');
                loadingSpinner.classList.add('d-flex');
            }

            fetch(this.action, {
                method: this.method,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (loadingSpinner) {
                    loadingSpinner.classList.add('d-none');
                    loadingSpinner.classList.remove('d-flex');
                }

                // Clear previous alert message
                if (alertMessage) {
                    alertMessage.classList.add('d-none');
                    alertMessage.classList.remove('alert-success', 'alert-danger');
                }

                if (data.success) {
                    if (alertMessage) {
                        alertMessage.classList.add('alert', 'alert-success');
                        alertMessage.textContent = data.message;
                        alertMessage.classList.remove('d-none');
                    }
                    Table(); // Refresh the user table
                    modal.hide(); // Close the modal after successful submission
                } else {
                    if (alertMessage) {
                        alertMessage.classList.add('alert', 'alert-danger');
                        alertMessage.textContent = data.message;
                        alertMessage.classList.remove('d-none');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);

                if (loadingSpinner) {
                    loadingSpinner.classList.add('d-none');
                    loadingSpinner.classList.remove('d-flex');
                }

                if (alertMessage) {
                    alertMessage.classList.add('alert', 'alert-danger');
                    alertMessage.textContent = 'An error occurred. Please try again.';
                    alertMessage.classList.remove('d-none');
                }
            });
        });
    }

    // Function to fetch and display user data
    function Table() {
        fetch('fetch_health.php')
            .then(response => response.json())
            .then(health => {
                console.log(health); // Check the data fetched from the server

                const display = document.getElementById('display');
                display.innerHTML = ''; // Clear the current table body

                health.forEach((health, index) => {
                    // const status_class = user.active_status === 'active' ? 'status-active' : 'status-inactive';
                    const fullname = health.Fname + " " + health.Lname;
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${fullname}</td>
                            <td>${health.Gender}</td>
                            <td>${health.Age}</td>
                            <td>${health.Purok}</td>
                            <td>${health.Weight}</td>
                            <td>${health.Height}</td>
                            <td>${health.Health_Status}</td>
                             <td>${health.Action_status}</td>
                            <td>${new Date(health.Created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</td>
                         <td>
                                        <a href="actions.php?approve=${health.id}" class="btn btn-success">Approve</a>
                                        <a href="actions.php?health_decline=${health.id}" class="btn btn-danger">Decline</a>
                                
                                    </td>
                            
                        </tr>
                    `;
                    display.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(error => console.error('Error fetching users:', error));
    }

    // Function to open and populate the Edit User modal
    window.openEditModal = function (userId) {
        // Fetch the user details using AJAX or prepare the modal with the necessary user info
        fetch(`fetch_user_by_id.php?id=${userId}`)
            .then(response => response.json())
            .then(user => {
                if (user) {
                    // Populate the modal fields with user data
                    document.getElementById('editFullName').value = user.fullname;
                    document.getElementById('editEmail').value = user.email;
                    document.getElementById('editUserId').value = user.id;  
                }
            })
            .catch(error => console.error('Error:', error));
    };
});


</script>

</script>
</body>
</html>

