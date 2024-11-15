<?php

include 'config/db.php';
if (isset($_POST['barcode'])) {
    $box_id = $_POST['barcode'];
    
    $result = $conn->query("SELECT item_id, box_id_fk, barcode FROM item WHERE box_id_fk = '$box_id'");
    
    $items = array();
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    // Return items array as JSON
    echo json_encode($items);

    $conn->close();
}
?>