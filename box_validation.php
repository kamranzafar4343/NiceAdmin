<?php
include 'config/db.php';

if (isset($_POST['box_name'])) {
    $box_name = mysqli_real_escape_string($conn, $_POST['box_name']);

    $nameCheck = "SELECT * FROM `box` WHERE `box_name` = '$box_name'";
    $nameCheckResult = $conn->query($nameCheck);
    
    if ($nameCheckResult->num_rows > 0) {
        echo 'exists';
    } else {
        echo 'not_exists';
    }
}
