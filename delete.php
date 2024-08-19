<?php
include "db.php";

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Ensure ID is an int

    // Prepare and execute the delete query
   echo $sql = "DELETE FROM `compani` WHERE `comp_id`='$user_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted success";
        header('Location: tables-data.php');
        exit(); // Make sure no further code is executed after redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
