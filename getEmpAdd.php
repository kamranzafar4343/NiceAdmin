<?php

include 'config/db.php'; // Your DB connection file

if (isset($_GET['emp_id'])) {
    $emp_id = $_GET['emp_id'];


    // Get branch id of employee
    $getBranchId = "SELECT * FROM employee WHERE emp_id = '$emp_id'";
    $resultData = mysqli_query($conn, $getBranchId);

    if ($resultData->num_rows > 0) {
        $row2 = $resultData->fetch_assoc();

        $branch_id = $row2['branch_id_fk'];
    }

    //Get address using branch 
    $query = "SELECT address FROM branches WHERE branch_id = $branch_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['address' => ''], JSON_FORCE_OBJECT); // Ensure consistent object output
    }
} else {
    echo json_encode(['address' => ''], JSON_FORCE_OBJECT);
}
