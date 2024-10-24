<?php
include 'config/db.php';

if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
    
    // Simple SQL query to get barcodes of selected branch
    $result = $conn->query("SELECT box_id, object, barcode FROM box WHERE `level2` = '$branch_id'");
    
    //store data into array
    $boxes = array();
    while ($row = $result->fetch_assoc()) {
        $boxes[] = $row;
    }
    
    // Return branches as JSON
    echo json_encode($boxes);
    
    $conn->close();
}
?>
