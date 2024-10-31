<?php

include 'config/db.php';
if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
    
    // Simple SQL query to get branches for the selected company
    $result = $conn->query("SELECT * FROM employee WHERE branch_FK_emp = '$branch_id'");
    
    $employees = array();
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
    
    // Return branches as JSON
    echo json_encode($employees);

    $conn->close();
}
?>