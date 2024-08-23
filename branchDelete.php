<?php
include "db.php";

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Ensure ID is an int


    // Prepare and execute the delete query
    $sql = "DELETE FROM `branch` WHERE `branch_id`='$user_id'";
    
    
    if ($conn->query($sql) === TRUE) {
        
        echo "<script> alert('record deleted');</script>";

        // header("Location: table-data2.php");
 
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
