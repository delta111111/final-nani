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
    <title>BNS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .navbar { background-color: #2c3e50; }
        .navbar-brand img { max-height: 50px; border-radius: 50%; }

        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --light-background: #f4f6f9;
        }
        body {
            background-color: var(--light-background);
        }
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 10px 0;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            max-height: 50px;
            margin-right: 15px;
            border-radius: 50%;
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
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: none;
        }
        .logout-btn {
            color: #dc3545;
        }
        .logout-btn:hover {
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
  
   <?php include 'navbar.php';  ?>

    <!-- Patient Management Container -->
  <div class="container-fluid mt-5 ">
    <div class="card">
        <!-- Card Header: Title, Search/Input Area, and Action Buttons -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Patient Records</h3>
            <div class="d-flex">
                <!-- Search bar -->
                <input type="text" id="searchInput" class="form-control me-2" placeholder="Search Patients" style="width: 250px;">
                
                <!-- Add New User Button -->
                <button class="btn btn-primary ms-2" id="addPatientBtn">
                    <i class="fas fa-plus me-2"></i>Add New Record
                </button>

                <!-- Print and Download Buttons -->
                <button class="btn btn-secondary ms-2" id="printBtn">
                    <i class="fas fa-print me-2"></i>Print
                </button>

              <button class="btn btn-success ms-2" id="downloadBtn">
    <i class="fas fa-download me-2"></i>Download CSV
</button>
            </div>
        </div>

        <!-- Card Body: Table and Show Entries Filter -->
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <label for="showEntries">Show Entries: </label>
                    <select id="showEntries" class="form-select d-inline-block" style="width: auto;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>

            <!-- Table for Patient Data -->
            <table id="patientsTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Barangay</th>
                        <th>Purok</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>Health Status</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="patientsTableBody">
                    <!-- Data will be injected here -->
                </tbody>
            </table>
        </div>

        <!-- Card Footer: Pagination Controls -->
        <div class="card-footer">
            <nav aria-label="Page navigation">
                <ul id="pagination" class="pagination justify-content-center">
                    <!-- Pagination buttons will be dynamically inserted here -->
                </ul>
            </nav>
        </div>
    </div>
</div>


<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- Adjusted size to large -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addPatientForm">
          <!-- Row 1: Name fields -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="fname" class="form-label">First Name</label>
              <input type="text" class="form-control" id="fname" name="fname" required>
            </div>
            <div class="col-md-6">
              <label for="lname" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lname" name="lname" required>
            </div>
          </div>

          <!-- Row 2: Gender and Age -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-select" id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="age" class="form-label">Age</label>
              <input type="number" class="form-control" id="age" name="age" required>
            </div>
          </div>


              <div class="mb-3">
 
            <label for="barangay">Barangay</label>
                <select name="barangay" class="form-select" id="barangay">
                   <option value="" disabled selected> Select Barangay...</option>
                   <option value="daragan">Daragan</option>
                   <option value="piña">Piña</option>
 
                </select>
          </div>

          <!-- Row 3: Address -->
          <div class="mb-3">
 
            <label for="purok">Purok</label>
                <select name="addpurok" class="form-select" id="purok">
                   <option value="" disabled selected> Select Purrok...</option>
                   <option value="pag_asa">Pag-Asa</option>
                   <option value="makalilibang">Makalilibang</option> 
                   <option value="masagana">Masagana</option> 
                   <option value="mahinahon">Mahinahon</option> 
                   <option value="maligaya">Maligaya</option> 
                   <option value="matibay">Matibay</option> 
                   <option value="mabuhay">Mabuhay</option>
                    <option value="matulungin">Matulungin</option>
                    <option value="maunlad">Maunlad</option> 
 
                </select>
          </div>

          <!-- Row 4: Weight and Height -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="weight" class="form-label">Weight (kg)</label>
              <input type="number" class="form-control" id="weight" name="weight" required>
            </div>
            <div class="col-md-6">
              <label for="height" class="form-label">Height (cm)</label>
              <input type="number" class="form-control" id="height" name="height" required>
            </div>
          </div>

          <!-- Row 5: Health Status -->
          <div class="mb-3">
            <label for="health">Health Status</label>
                <select name="addhealth_status" id="health" class="form-control" required>
                    <option value="" selected disabled>Select...</option>
                    <?php 
                    include 'dbcon.php';
                     $sql = "SELECT * FROM health_conditions";

                   $result = mysqli_query($connection,$sql);

                   if(!$result){
                        die("query failed".mysqli_error() );
                     }
                       else{

                         while($row = mysqli_fetch_assoc($result)){
                    $health_conditions = $row['ConditionName'];
                    
                     echo "<option value='$health_conditions'>$health_conditions</option>";


                    }



                }
                    ?>

                </select>
          </div>


          <!-- Submit Button -->
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Add Patient</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Edit Patient Modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPatientModalLabel">Update Patient Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPatientForm">
                    <input type="hidden" id="patientId" name="patientId"> <!-- Hidden input to store patient id -->
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="weight" class="form-label">Weight</label>
                        <input type="number" class="form-control" id="weight" name="weight" required>
                    </div>
                    <div class="mb-3">
                        <label for="height" class="form-label">Height</label>
                        <input type="number" class="form-control" id="height" name="height" required>
                    </div>
                    <div class="mb-3">
                        <label for="health_status" class="form-label">Health Status</label>
                        <input type="text" class="form-control" id="health_status" name="health_status" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Patient</button>
                </form>
            </div>
        </div>
    </div>
</div>




   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

  
    <script>

          function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
  $(document).ready(function() {
    
    loadPatients();

    // Search filter
    $('#searchInput').on('input', function() {
        loadPatients();
    });

      $('#addPatientBtn').click(function() {
    $('#addPatientModal').modal('show');
  })

    // Change entries per page
    $('#showEntries').on('change', function() {
        loadPatients();
    });


     $('#addPatientForm').submit(function(event) {
        event.preventDefault(); 
        const formData = $(this).serialize();

        $.ajax({
            url: 'add_new_record.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#addPatientModal').modal('hide');
                    loadPatients(); 
                } else {
                    alert('Error: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error adding patient: ' + error);
            }
        });
    });


      $(document).on('click', '.edit-btn', function() {
        var patientId = $(this).data('id');
        // Open the modal and populate the form with patient details
        // For example, you can send an AJAX request to fetch the details for that patient
        $.ajax({
            url: 'actions.php', // Example URL to fetch patient details
            method: 'GET',
            data: { update_id: patientId },
            success: function(response) {
                // Assuming the response is the patient's data
                var patient = JSON.parse(response);
                // Populate modal form fields
                $('#editPatientModal #fname').val(patient.Fname);
                $('#editPatientModal #lname').val(patient.Lname);
                $('#editPatientModal #gender').val(patient.Gender);
                $('#editPatientModal #age').val(patient.Age);
                $('#editPatientModal #address').val(patient.Purok);
                $('#editPatientModal #weight').val(patient.Weight);
                $('#editPatientModal #height').val(patient.Height);
                $('#editPatientModal #health_status').val(patient.Health_Status);
                $('#editPatientModal').modal('show'); // Open the modal
            }
        });
    });
   

   $('#updatePatientForm').on('submit', function(e) {
    e.preventDefault();  // Prevent default form submission

    var formData = $(this).serialize();  // Serialize the form data

    $.ajax({
        url: 'actions.php',  // PHP file that handles update query
        method: 'POST',
        data: formData,  // Send the form data including the update_id
        success: function(response) {
            if (response === 'success') {
                alert('Patient record updated successfully!');
                $('#updatePatientModal').modal('hide');
                loadPatients();  // Reload patient data
            } else {
                alert('Error updating patient record.');
            }
        }
    });
});
    



    // Pagination handler
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        window.history.pushState({}, '', `?page=${page}`);
        loadPatients();
    });

    // Get URL parameter for page number
  
});





      document.getElementById('printBtn').addEventListener('click', function() {
        const printContent = document.getElementById('patientsTable').outerHTML;
        const printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">');
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });

    // Handle Download functionality (Download as CSV)
    // document.getElementById('downloadBtn').addEventListener('click', function() {
    //     const table = document.getElementById('patientsTable');
    //     let csv = [];
    //     const rows = table.querySelectorAll('tr');

    //     // Loop through each row
    //     rows.forEach(function(row) {
    //         const cols = row.querySelectorAll('td, th');
    //         let rowData = [];
    //         cols.forEach(function(col) {
    //             rowData.push(col.innerText);
    //         });
    //         csv.push(rowData.join(','));
    //     });

    //     // Create CSV file and trigger download
    //     const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    //     const link = document.createElement('a');
    //     link.href = URL.createObjectURL(csvFile);
    //     link.download = 'patients_data.csv';
    //     link.click();
    // })


    // Get the table and extract rows
    const table = document.getElementById('patientsTable');
    let csv = [];

    // Define the columns to include in the CSV (adjusted to match the order in the table)
    const columnsToDownload = [
        'Fname', 'Lname', 'Gender', 'Age', 'Barangay', 'Purok', 'Weight', 'Height', 'Health Status', 'Date Created'
    ];
     document.getElementById("downloadBtn").addEventListener("click", function() {

    // Add headers to CSV
    csv.push(columnsToDownload.join(','));

    // Extract table data rows
    const rows = table.querySelectorAll('tr');
    rows.forEach(function(row, index) {
        // Skip the first row (headers)
        if (index === 0) return;

        const cols = row.querySelectorAll('td');
        const rowData = [];

        // Ensure each column's data is collected in the correct order
        rowData.push(cols[1]?.innerText || ''); // Fname
        rowData.push(cols[2]?.innerText || ''); // Lname
        rowData.push(cols[3]?.innerText || ''); // Gender
        rowData.push(cols[4]?.innerText || ''); // Age
        rowData.push(cols[5]?.innerText || ''); // Purok
        rowData.push(cols[6]?.innerText || ''); // Purok
        rowData.push(cols[7]?.innerText || ''); // Weight
        rowData.push(cols[8]?.innerText || ''); // Height
        rowData.push(cols[9]?.innerText || ''); // Health Status
        rowData.push(cols[10]?.innerText || ''); // Date Created (last column)

        // Filter only the columns specified in columnsToDownload
        csv.push(rowData.join(','));
    });

    // Create a Blob with the CSV content
    const csvContent = csv.join("\n");
    const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });

    // Create a link to trigger the download
    const link = document.createElement("a");
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "patients_data.csv");
        link.style.visibility = 'hidden';

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
});



 function DeleteBtn(del) {
  if (confirm("Are you sure you want to delete this record?")) {
    $.ajax({
      url: "delete.php",
      method: "POST",
      data: { delete_id: del },
      success: (response) => {
        if (response === "success") {
   
          loadPatients(); 
        } 
      },
      error: (xhr, status, error) => {
        alert("Error: " + error);
      },
    });
  }
}
    


function loadPatients() {
  const search = $('#searchInput').val();
  const entries = $('#showEntries').val();
  const page = getUrlParameter('page') || 1;

  $.ajax({
    url: 'patients_data.php',
    method: 'GET',
    data: { search: search, entries: entries, page: page },
   success: function(data) {
  try {
    var jsonData = JSON.parse(data);  // Parsing the response as JSON
    console.log(jsonData);  // Log the parsed data to debug

    if (jsonData.patientsHTML) {
      $('#patientsTableBody').html(jsonData.patientsHTML); // Insert patient rows into table
    } else {
      $('#patientsTableBody').html('<tr><td colspan="11">No data available.</td></tr>');
    }

    if (jsonData.paginationHTML) {
      $('#pagination').html(jsonData.paginationHTML);  // Insert pagination
    } else {
      $('#pagination').html('<li class="page-item disabled"><a class="page-link" href="#">No pages</a></li>');
    }
  } catch (e) {
    console.log("Error parsing JSON response: " + e.message);
  }
},

    error: function(xhr, status, error) {
      console.log("Error: " + error); // Log any AJAX errors
    }
  });
}





    </script>
</body>
</html>
