<?php
include 'dbcon.php';

// Handle search, pagination, and show entries
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$limit = isset($_GET['entries']) ? intval($_GET['entries']) : 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Adjust the query to match your database table
$sql = "SELECT * FROM table_form WHERE Fname LIKE ? OR Lname LIKE ? LIMIT ? OFFSET ?";
$stmt = $connection->prepare($sql);
$searchTerm = "%$searchQuery%";
$stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$patientsHTML = '';
while ($row = $result->fetch_assoc()) {
    $patient_id = $row['id'];
    $patientsHTML .= '<tr>
        <td>' . $row['id']. '</td>
        <td>' . htmlspecialchars($row['Fname']) . '</td>
        <td>' . htmlspecialchars($row['Lname']) . '</td>
        <td>' . htmlspecialchars($row['Gender']) . '</td>
        <td>' . htmlspecialchars($row['Age']) . '</td>
        <td>' . htmlspecialchars($row['Barangay']) . '</td>
        <td>' . htmlspecialchars($row['Purok']) . '</td>
        <td>' . htmlspecialchars($row['Weight']) . '</td>
        <td>' . htmlspecialchars($row['Height']) . '</td>
        <td>' . htmlspecialchars($row['Health_Status']) . '</td>
        <td>' . htmlspecialchars($row['Created_at']) . '</td>
        <td>
            <a href="javascript:void(0);" class="btn btn-sm btn-warning edit-btn" data-id="' . $patient_id . '">Edit</a>
            <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="DeleteBtn(' . $patient_id . ')">Delete</a>
        </td>
    </tr>';
}

// If no patients are found
if (empty($patientsHTML)) {
    $patientsHTML = '<tr><td colspan="12">No data available.</td></tr>';
}

// Generate pagination HTML
$sqlTotal = "SELECT COUNT(*) as total FROM table_form WHERE Fname LIKE ? OR Lname LIKE ?";
$stmtTotal = $connection->prepare($sqlTotal);
$stmtTotal->bind_param("ss", $searchTerm, $searchTerm);
$stmtTotal->execute();
$totalResult = $stmtTotal->get_result();
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

$paginationHTML = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == $page) ? ' active' : '';
    $paginationHTML .= '<li class="page-item' . $activeClass . '"><a class="page-link" href="#" data-page="'.$i.'">'.$i.'</a></li>';
}

// Return data as JSON
echo json_encode([
    'patientsHTML' => $patientsHTML,
    'paginationHTML' => $paginationHTML,
    'totalRows' => $totalRows
]);

