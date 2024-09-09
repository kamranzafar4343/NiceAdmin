<?php

// session_start(); // Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to login page
    header("Location: pages-login.php");
    exit();
}

include "db.php";

if (isset($_GET['id'])) {
    $box_id = intval($_GET['id']); // Ensure box ID is an integer

    // Fetch the company ID associated with the branch from the compID_FK column
    $sql = "SELECT `branchID_FK` FROM `box` WHERE `box_id` = $box_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $branch_id = $row['branchID_FK'];

        // Now, perform the delete operation
        $delete_sql = "DELETE FROM `box` WHERE `box_id` = $box_id";
        if ($conn->query($delete_sql) === TRUE) {
            // Redirect to the branch box page after successful deletion
            header("Location: box.php?id=" . $branch_id);
            exit;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error: No company found for this branch.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No branch ID provided.";
}
