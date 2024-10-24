<?php
include 'config/db.php';

if (isset($_POST['acc_lev_1'])) {
    $acc_lev_1 = mysqli_real_escape_string($conn, $_POST['acc_lev_1']);

    // Check if the email already exists in the database
    $accCheckQuery = "SELECT * FROM `compani` WHERE `acc_lev_1` = '$acc_lev_1'";
    $result = $conn->query($accCheckQuery);

    if ($result->num_rows > 0) { 
        echo 'Account already exists';
    } else {
        echo '';
    }
}
?>
