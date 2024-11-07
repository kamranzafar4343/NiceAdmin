<?php
include 'config/db.php';

if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
    
    // Simple SQL query to get emp's for the selected branch
    $result = $conn->query("SELECT * FROM employee WHERE branch_id_fk = '$branch_id'");
    
    //store data into array
    $employees = array();
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
    
    // Return dept's as JSON
    echo json_encode($employees);
    
    $conn->close();
}
?>