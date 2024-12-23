<?php

include 'config/db.php'; // Your DB connection file

if (isset($_GET['emp_id'])) {
    $emp_id = $_GET['emp_id'];
    $query = "SELECT phone FROM employee WHERE emp_id = $emp_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['phone' => ''], JSON_FORCE_OBJECT); // Ensure consistent object output
    }
} else {
    echo json_encode(['phone' => ''], JSON_FORCE_OBJECT);
}
