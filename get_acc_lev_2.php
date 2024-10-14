<?php
include 'config/db.php';

if (isset($_POST['company_id'])) {
    // Escape the company_id to prevent SQL injection
    $company_id = $conn->real_escape_string($_POST['company_id']);

    // Prepare and execute the query to fetch acc_lev_2 from branches where comp_id_fk matches the selected company_id
    $query = "SELECT branch_id, acc_lev_2 FROM branches WHERE comp_id_fk = '$company_id'";
    $result = $conn->query($query);

    // Initialize an array to store the results
    $acc_lev_2_data = [];

    // Fetch data and store it in the array
    while ($row = $result->fetch_assoc()) {
        $acc_lev_2_data[] = $row;
    }

    // Return the results in JSON format
    echo json_encode($acc_lev_2_data);
}
?>
