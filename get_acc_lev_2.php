<?php
include 'config/db.php';

if (isset($_POST['company_id'])) {
    $company_id = $_POST['company_id'];
    
    // Simple SQL query to get branches for the selected company
    $result = $conn->query("SELECT comp_id, acc_lev_2 FROM compani WHERE comp_id = '$company_id'");
    
    //store data into array
    $acc_lev_2 = array();
    while ($row = $result->fetch_assoc()) {
        $acc_lev_2[] = $row;
    }
    

    // Return branches as JSON
    echo json_encode($acc_lev_2);
    
    $conn->close();
}
?>
