<?php
// Database connection (ensure you have initialized $conn correctly)
include 'db_connection.php'; // Replace with your actual database connection script

// Get emp_id from POST data
$emp_id = $_POST['emp_id'] ?? '';

// Check if emp_id is provided
if (!empty($emp_id)) {
    // Prepare a SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT phone FROM employee WHERE emp_id = ?");
    $stmt->bind_param("s", $emp_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the phone number
    if ($employee = $result->fetch_assoc()) {
        echo json_encode(['phone' => $employee['phone']]);
    } else {
        echo json_encode(['phone' => null]); // No phone found for this employee
    }

    // Close statement and connection
    $stmt->close();
} else {
    echo json_encode(['phone' => null]); // No emp_id provided
}

// Close the database connection
$conn->close();
?>

