<?php

include 'config/db.php';

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    // echo $box_id;
    
    //get box_id through the barcode
    $resultBoxId = $conn->query("SELECT box_id FROM box WHERE barcode = '$barcode'");
    $rowBoxId = $resultBoxId->fetch_assoc();
    $box_id = $rowBoxId['box_id'];

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