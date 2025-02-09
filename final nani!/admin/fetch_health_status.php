<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../connection.php';

header('Content-Type: application/json');

try {
    $purok = isset($_GET['purok']) ? $_GET['purok'] : null;
    $barangay = isset($_GET['barangay']) ? $_GET['barangay'] : null;

    if (!$purok) {
        throw new Exception('Invalid or missing Purok');
    }

    // Debug: Log the received Purok
    error_log("Received Purok: " . $purok);

    // Updated query: Join with the purok_area table to get the assigned user's fullname
 $stmt = $conn->prepare("
  SELECT hc.ConditionName, 
         IFNULL(COUNT(tf.Health_Status), 0) AS count
  FROM health_conditions hc
  LEFT JOIN table_form tf ON tf.Health_Status = hc.ConditionName 
    AND tf.Purok = ? 
    AND tf.barangay = ?
  LEFT JOIN purok_area pa ON pa.assign_area = ? 
  GROUP BY hc.ConditionName;
");


    $stmt->bind_param("sss", $purok, $barangay, $purok); 
    $stmt->execute();
    $result = $stmt->get_result();

    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
    $stmt->close();

    // Debug: Log the health conditions response
    error_log("Health conditions response: " . json_encode($response));

    // Fetch the health status from the table_form
    $healthStatusStmt = $conn->prepare("
        SELECT Health_Status 
        FROM table_form 
        WHERE Purok = ? 
        LIMIT 1
    ");
    $healthStatusStmt->bind_param("s", $purok);
    $healthStatusStmt->execute();
    $healthStatusResult = $healthStatusStmt->get_result();
    $healthStatusDetails = $healthStatusResult->fetch_assoc();
    $healthStatusStmt->close();

    if (!$healthStatusDetails || empty($healthStatusDetails['Health_Status'])) {
        $healthStatusDetails = ['Health_Status' => 'No details available'];
    }

    // Debug: Log the health status details
    error_log("Health status details: " . json_encode($healthStatusDetails));

    // Calculate the total count of all conditions
    $totalCount = array_sum(array_column($response, 'count'));

    $conn->close();

    // Prepare final response
    $responseData = [
        'success' => true,
        'details' => $healthStatusDetails,
        'counts' => $response,
        'totalCount' => $totalCount
    ];

    // Debug: Log the final response data
    error_log("Final response data: " . json_encode($responseData));

    // Output the response in JSON format
    echo json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    $errorResponse = [
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ];
    error_log("Error in fetch_health_status.php: " . $e->getMessage());
    echo json_encode($errorResponse);
}
