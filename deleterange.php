<?php

// session_start(); // Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}
include 'config/db.php';

if (isset($_GET['id'])) {
    $range_id = intval($_GET['id']); // Ensure ID is an int

    // Prepare and execute the delete query
   $sql = "DELETE FROM `acc_range` WHERE `range_id`='$range_id'";
    
    if ($conn->query($sql) === TRUE) {
        
        header('Location: account.php');
        exit(); // Make sure no further code is executed after redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>