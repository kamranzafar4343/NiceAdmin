<?php
include 'config/db.php';

if (isset($_POST['company_id'])) {
    $company_id = $_POST['company_id'];
    
    // Simple SQL query to get branches for the selected company
    $result = $conn->query("SELECT branch_id, branch_name FROM branch WHERE compID_FK = '$company_id'");
    
    //store data into array
    $branches = array();
    while ($row = $result->fetch_assoc()) {
        $branches[] = $row;
    }
    

    // Return branches as JSON
    echo json_encode($branches);
    
    $conn->close();
}
?>
