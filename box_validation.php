<?php
include 'config/db.php';

if (isset($_POST['box_name'])) {
    $box_name = mysqli_real_escape_string($conn, $_POST['box_name']);

    // Check if the box name and barcode already exists in the database
    $nameCheck = "SELECT * FROM `box` WHERE `box_name` = '$box_name'";
    $nameCheckResult = $conn->query($nameCheck);
    
    if ($result->num_rows > 0) {
        echo 'exists';
    } else {
        echo 'not_exists';
    }
}
