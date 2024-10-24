<?php
include 'config/db.php';

if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
    
    // Simple SQL query to get dept's for the selected company
    $result = $conn->query("SELECT dept_id, acc_lev_3, acc_desc FROM departments WHERE branch_id_fk = '$branch_id'");
    
    //store data into array
    $departments = array();
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
    
    // Return dept's as JSON
    echo json_encode($departments);
    
    $conn->close();
}
?>
