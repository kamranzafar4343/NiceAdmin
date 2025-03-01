<?php

include 'config/db.php';
if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];

    // Simple SQL query to get barcodes for the selected branches
    $result = $conn->query("SELECT * FROM box WHERE branch_id_fk = '$branch_id' AND location IS NOT NULL AND status = 'In';");

    $boxes = array();
    while ($row = $result->fetch_assoc()) {
        $boxes[] = $row;
    }

    // Return branches as JSON
    echo json_encode($boxes);

    $conn->close();
}
