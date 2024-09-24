<?php
include "db.php"; // Database connection

if (isset($_GET['box_id'])) {
    $box_id = $_GET['box_id'];

    // Fetch item barcode using box_id
    $query = "SELECT barcode FROM item WHERE box_FK_item = '$box_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['item_barcode']; // Output the barcode
    } else {
        echo ''; // No item found, return empty
    }
}
?>
