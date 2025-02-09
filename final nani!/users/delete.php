
<?php
include 'dbcon.php';

// Delete patient
if (isset($_POST['delete_id'])) {
    $patientId = intval($_POST['delete_id']);
    $sql = "DELETE FROM table_form WHERE id = ?";
    $stmt = $connection->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement: ' . $connection->error]);
        exit;
    }
    $stmt->bind_param("i", $patientId);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Patient deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No rows affected. Patient ID might not exist.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to execute statement: ' . $stmt->error]);
    }
    $stmt->close();
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);


?>